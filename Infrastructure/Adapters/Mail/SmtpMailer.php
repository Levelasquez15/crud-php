<?php
// Infrastructure/Adapters/Mail/SmtpMailer.php

class SmtpMailer {
    private MailerConfig $config;

    public function __construct(MailerConfig $config) {
        $this->config = $config;
    }

    public function send(string $to, string $subject, string $htmlBody, string $fromName = 'CRUD Hexagonal'): bool {
        $host = $this->config->getHost();
        $port = $this->config->getPort();
        $username = trim($this->config->getUsername());
        $password = str_replace(' ', '', trim($this->config->getPassword()));

        if ($username === '' || str_contains($username, 'tu_email@')) {
            throw new RuntimeException('Configura tu correo Gmail real en DependencyInjection::getMailer().');
        }

        $socket = stream_socket_client(
            "ssl://{$host}:{$port}",
            $errno,
            $errstr,
            30,
            STREAM_CLIENT_CONNECT
        );

        if (!$socket) {
            throw new RuntimeException("No se pudo conectar al SMTP: {$errstr} ({$errno})");
        }

        stream_set_timeout($socket, 30);

        $this->expectCode($socket, [220]);
        $this->sendCommand($socket, 'EHLO localhost', [250]);
        $this->sendCommand($socket, 'AUTH LOGIN', [334]);
        $this->sendCommand($socket, base64_encode($username), [334]);
        $this->sendCommand($socket, base64_encode($password), [235]);
        $this->sendCommand($socket, 'MAIL FROM:<' . $username . '>', [250]);
        $this->sendCommand($socket, 'RCPT TO:<' . $to . '>', [250, 251]);
        $this->sendCommand($socket, 'DATA', [354]);

        $encodedFromName = mb_encode_mimeheader($fromName, 'UTF-8');
        $encodedSubject = mb_encode_mimeheader($subject, 'UTF-8');

        $headers = [];
        $headers[] = 'From: ' . $encodedFromName . ' <' . $username . '>';
        $headers[] = 'Reply-To: ' . $username;
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = 'Content-Transfer-Encoding: 8bit';

        $message = "To: <{$to}>\r\n"
            . 'Subject: ' . $encodedSubject . "\r\n"
            . implode("\r\n", $headers)
            . "\r\n\r\n"
            . $htmlBody
            . "\r\n.\r\n";

        fwrite($socket, $message);
        $this->expectCode($socket, [250]);
        $this->sendCommand($socket, 'QUIT', [221]);

        fclose($socket);
        return true;
    }

    private function sendCommand($socket, string $command, array $expectedCodes): void {
        fwrite($socket, $command . "\r\n");
        $this->expectCode($socket, $expectedCodes);
    }

    private function expectCode($socket, array $expectedCodes): void {
        $response = '';
        while (($line = fgets($socket, 515)) !== false) {
            $response .= $line;
            // Multi-line SMTP replies have '-' in the 4th char, final line has a space.
            if (strlen($line) >= 4 && $line[3] === ' ') {
                break;
            }
        }

        $code = (int)substr($response, 0, 3);
        if (!in_array($code, $expectedCodes, true)) {
            throw new RuntimeException('Error SMTP: ' . trim($response));
        }
    }
}

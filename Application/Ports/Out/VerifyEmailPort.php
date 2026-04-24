<?php
// Application/Ports/Out/VerifyEmailPort.php

interface VerifyEmailPort {
    public function findByToken(string $token): ?UserModel;
    public function markAsVerified(string $id): void;
}

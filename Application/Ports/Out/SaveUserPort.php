<?php
// Application/Ports/Out/SaveUserPort.php

interface SaveUserPort {
    public function save(UserModel $user, ?string $emailVerificationToken = null): UserModel;
}

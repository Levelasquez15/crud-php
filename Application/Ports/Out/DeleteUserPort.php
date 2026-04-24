<?php
// Application/Ports/Out/DeleteUserPort.php

interface DeleteUserPort {
    public function delete(UserId $id): void;
}

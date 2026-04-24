<?php
// Common/ClassLoader.php

class ClassLoader {
    private static array $classMap = [
        'InvalidUserEmailException'  => 'Domain/Exceptions/InvalidUserEmailException.php',
        'InvalidUserIdException'     => 'Domain/Exceptions/InvalidUserIdException.php',
        'InvalidUserNameException'   => 'Domain/Exceptions/InvalidUserNameException.php',
        'InvalidUserPasswordException'=> 'Domain/Exceptions/InvalidUserPasswordException.php',
        'InvalidUserRoleException'   => 'Domain/Exceptions/InvalidUserRoleException.php',
        'InvalidUserStatusException' => 'Domain/Exceptions/InvalidUserStatusException.php',
        'UserAlreadyExistsException' => 'Domain/Exceptions/UserAlreadyExistsException.php',
        'UserNotFoundException'      => 'Domain/Exceptions/UserNotFoundException.php',
        'InvalidCredentialsException'=> 'Domain/Exceptions/InvalidCredentialsException.php',
        
        'UserRoleEnum'               => 'Domain/Enums/UserRoleEnum.php',
        'UserStatusEnum'             => 'Domain/Enums/UserStatusEnum.php',
        
        'UserId'                     => 'Domain/ValueObjects/UserId.php',
        'UserName'                   => 'Domain/ValueObjects/UserName.php',
        'UserEmail'                  => 'Domain/ValueObjects/UserEmail.php',
        'UserPassword'               => 'Domain/ValueObjects/UserPassword.php',
        
        'UserModel'                  => 'Domain/Models/UserModel.php',

        'CreateUserCommand'          => 'Application/Services/Dto/Commands/CreateUserCommand.php',
        'UpdateUserCommand'          => 'Application/Services/Dto/Commands/UpdateUserCommand.php',
        'DeleteUserCommand'          => 'Application/Services/Dto/Commands/DeleteUserCommand.php',
        'LoginCommand'               => 'Application/Services/Dto/Commands/LoginCommand.php',
        
        'GetUserByIdQuery'           => 'Application/Services/Dto/Queries/GetUserByIdQuery.php',
        'GetAllUsersQuery'           => 'Application/Services/Dto/Queries/GetAllUsersQuery.php',
        
        'SaveUserPort'               => 'Application/Ports/Out/SaveUserPort.php',
        'UpdateUserPort'             => 'Application/Ports/Out/UpdateUserPort.php',
        'DeleteUserPort'             => 'Application/Ports/Out/DeleteUserPort.php',
        'GetUserByIdPort'            => 'Application/Ports/Out/GetUserByIdPort.php',
        'GetUserByEmailPort'         => 'Application/Ports/Out/GetUserByEmailPort.php',
        'GetAllUsersPort'            => 'Application/Ports/Out/GetAllUsersPort.php',
        
        'CreateUserUseCase'          => 'Application/Ports/In/CreateUserUseCase.php',
        'UpdateUserUseCase'          => 'Application/Ports/In/UpdateUserUseCase.php',
        'DeleteUserUseCase'          => 'Application/Ports/In/DeleteUserUseCase.php',
        'GetUserByIdUseCase'         => 'Application/Ports/In/GetUserByIdUseCase.php',
        'GetAllUsersUseCase'         => 'Application/Ports/In/GetAllUsersUseCase.php',
        'LoginUseCase'               => 'Application/Ports/In/LoginUseCase.php',
        
        'UserApplicationMapper'      => 'Application/Services/Mappers/UserApplicationMapper.php',
        
        'CreateUserService'          => 'Application/Services/CreateUserService.php',
        'UpdateUserService'          => 'Application/Services/UpdateUserService.php',
        'DeleteUserService'          => 'Application/Services/DeleteUserService.php',
        'GetUserByIdService'         => 'Application/Services/GetUserByIdService.php',
        'GetAllUsersService'         => 'Application/Services/GetAllUsersService.php',
        'LoginService'               => 'Application/Services/LoginService.php',
        
        'Connection'                 => 'Infrastructure/Adapters/Persistence/MySQL/Config/Connection.php',
        'UserPersistenceDto'         => 'Infrastructure/Adapters/Persistence/MySQL/Dto/UserPersistenceDto.php',
        'UserEntity'                 => 'Infrastructure/Adapters/Persistence/MySQL/Entity/UserEntity.php',
        'UserPersistenceMapper'      => 'Infrastructure/Adapters/Persistence/MySQL/Mapper/UserPersistenceMapper.php',
        'UserRepositoryMySQL'        => 'Infrastructure/Adapters/Persistence/MySQL/Repository/UserRepositoryMySQL.php',
        
        'CreateUserWebRequest'       => 'Infrastructure/Entrypoints/Web/Controllers/Dto/CreateUserWebRequest.php',
        'UpdateUserWebRequest'       => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UpdateUserWebRequest.php',
        'LoginWebRequest'            => 'Infrastructure/Entrypoints/Web/Controllers/Dto/LoginWebRequest.php',
        'UserResponse'               => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UserResponse.php',
        'UserWebMapper'              => 'Infrastructure/Entrypoints/Web/Controllers/Mapper/UserWebMapper.php',
        'WebRoutes'                  => 'Infrastructure/Entrypoints/Web/Controllers/Config/WebRoutes.php',
        'UserController'             => 'Infrastructure/Entrypoints/Web/Controllers/UserController.php',
        'AuthController'             => 'Infrastructure/Entrypoints/Web/Controllers/AuthController.php',
        'HomeController'             => 'Infrastructure/Entrypoints/Web/Controllers/HomeController.php',
        
        'MailerConfig'               => 'Infrastructure/Adapters/Mail/MailerConfig.php',
        'SmtpMailer'                 => 'Infrastructure/Adapters/Mail/SmtpMailer.php',
        'Migration'                  => 'Infrastructure/Adapters/Persistence/MySQL/Config/Migration.php',
        'VerifyEmailPort'            => 'Application/Ports/Out/VerifyEmailPort.php',
        'VerifyEmailUseCase'         => 'Application/Ports/In/VerifyEmailUseCase.php',
        'VerifyEmailCommand'         => 'Application/Services/Dto/Commands/VerifyEmailCommand.php',
        'VerifyEmailService'         => 'Application/Services/VerifyEmailService.php',
        
        'Flash'                      => 'Infrastructure/Entrypoints/Web/Presentation/Flash.php',
        'View'                       => 'Infrastructure/Entrypoints/Web/Presentation/View.php',
        'DependencyInjection'        => 'Common/DependencyInjection.php',
    ];

    public static function register(): void {
        spl_autoload_register([self::class, 'loadClass']);
    }

    public static function loadClass(string $className): void {
        if (!isset(self::$classMap[$className])) return;
        $filePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . self::$classMap[$className];
        if (file_exists($filePath)) {
            require_once $filePath;
        }
    }
}

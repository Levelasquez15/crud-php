<?php
// Infrastructure/Entrypoints/Web/Controllers/UserController.php

class UserController {
    private CreateUserUseCase $createUseCase;
    private UpdateUserUseCase $updateUseCase;
    private GetUserByIdUseCase $getByIdUseCase;
    private GetAllUsersUseCase $getAllUseCase;
    private DeleteUserUseCase $deleteUseCase;
    private UserWebMapper $webMapper;

    public function __construct(
        CreateUserUseCase $createUseCase,
        UpdateUserUseCase $updateUseCase,
        GetUserByIdUseCase $getByIdUseCase,
        GetAllUsersUseCase $getAllUseCase,
        DeleteUserUseCase $deleteUseCase,
        UserWebMapper $webMapper
    ) {
        $this->createUseCase = $createUseCase;
        $this->updateUseCase = $updateUseCase;
        $this->getByIdUseCase = $getByIdUseCase;
        $this->getAllUseCase = $getAllUseCase;
        $this->deleteUseCase = $deleteUseCase;
        $this->webMapper = $webMapper;
    }

    public function index(): array {
        $query = clone new GetAllUsersQuery(); 
        $users = $this->getAllUseCase->execute($query);
        return $this->webMapper->fromModelsToResponses($users);
    }

    public function show(string $id): UserResponse {
        $query = clone $this->webMapper->fromIdToGetByIdQuery($id);
        $user = $this->getByIdUseCase->execute($query);
        return $this->webMapper->fromModelToResponse($user);
    }

    public function create(): void {
        // En este patrón, si el controller retorna void, significa que la orquestación (index.php) 
        // solo necesitaba llamar al método para side effects, pero crear solo requiere la vista
        // Manejado en index.php por ser presentacional
    }

    public function store(CreateUserWebRequest $request): UserResponse {
        $command = clone $this->webMapper->fromCreateRequestToCommand($request);
        $user = $this->createUseCase->execute($command);
        return $this->webMapper->fromModelToResponse($user);
    }

    public function edit(string $id): UserResponse {
        $query = clone $this->webMapper->fromIdToGetByIdQuery($id);
        $user = $this->getByIdUseCase->execute($query);
        return $this->webMapper->fromModelToResponse($user);
    }

    public function update(UpdateUserWebRequest $request): UserResponse {
        $command = clone $this->webMapper->fromUpdateRequestToCommand($request);
        $user = $this->updateUseCase->execute($command);
        return $this->webMapper->fromModelToResponse($user);
    }

    public function delete(string $id): void {
        $command = clone $this->webMapper->fromIdToDeleteCommand($id);
        $this->deleteUseCase->execute($command);
    }
}

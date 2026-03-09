<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages\CreateUser;
use App\Filament\Admin\Resources\UserResource\Pages\EditUser;
use App\Filament\Admin\Resources\UserResource\Pages\ListUsers;
use App\Helpers\RoleHierarchy;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Usuarios';

    protected static ?string $modelLabel = 'Usuario';

    protected static ?string $pluralModelLabel = 'Usuarios';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Correo Electrónico')
                ->email()
                ->required()
                ->maxLength(255)
                ->unique(User::class, 'email', ignoreRecord: true),

            TextInput::make('password')
                ->label('Contraseña')
                ->password()
                ->revealable()
                ->minLength(8)
                ->required(fn (string $operation): bool => $operation === 'create')
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->dehydrateStateUsing(fn (string $state): string => bcrypt($state)),

            Select::make('roles')
                ->label('Rol')
                ->relationship('roles', 'name')
                ->options(fn () => static::getAssignableRoles())
                ->preload()
                ->searchable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('roles.name')
                    ->label('Rol')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'admin'       => 'warning',
                        'supervisor'  => 'info',
                        'empleado'    => 'success',
                        default       => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->visible(fn (User $record): bool => static::canEditUser($record)),

                DeleteAction::make()
                    ->visible(fn (User $record): bool => static::canEditUser($record)),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit'   => EditUser::route('/{record}/edit'),
        ];
    }

    /**
     * Solo mostramos usuarios cuyo nivel jerárquico es MENOR al del usuario autenticado.
     * El super_admin ve a todos los demás.
     */
    public static function getEloquentQuery(): Builder
    {
        $authUser = Auth::user();
        $query = parent::getEloquentQuery();

        if (! $authUser) {
            return $query;
        }

        // super_admin puede ver a todos, incluido el mismo.
        if ($authUser->hasRole('super_admin')) {
            return $query;
        }

        $authLevel = RoleHierarchy::getUserLevel($authUser);
        $rolesVisibles = RoleHierarchy::getRolesBelowLevel($authLevel);

        return $query->where(function (Builder $builder) use ($authUser, $rolesVisibles) {
            $builder
                ->where('id', $authUser->id)
                ->orWhereHas('roles', function (Builder $q) use ($rolesVisibles) {
                    $q->whereIn('name', $rolesVisibles);
                });
        });
    }

    /**
     * Roles que el usuario autenticado puede asignar (solo los de menor jerarquía)
     */
    public static function getAssignableRoles(): array
    {
        $authUser = Auth::user();

        if ($authUser->hasRole('super_admin')) {
            return Role::all()->pluck('name', 'id')->toArray();
        }

        $authLevel = RoleHierarchy::getUserLevel($authUser);
        $assignable = RoleHierarchy::getRolesBelowLevel($authLevel);

        return Role::whereIn('name', $assignable)->pluck('name', 'id')->toArray();
    }

    /**
     * Verifica si el usuario autenticado puede editar al usuario objetivo
     */
    public static function canEditUser(User $target): bool
    {
        $authUser = Auth::user();

        if ($authUser->hasRole('super_admin')) {
            return true;
        }

        $authLevel  = RoleHierarchy::getUserLevel($authUser);
        $targetLevel = RoleHierarchy::getUserLevel($target);

        // Solo puede editar si el objetivo tiene un nivel MAYOR (número mayor = menos poder)
        return $targetLevel > $authLevel;
    }
}

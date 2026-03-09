<?php

namespace App\Helpers;

use App\Models\User;

class RoleHierarchy
{
    /**
     * Mapa de jerarquía de roles.
     * Menor número = mayor poder / autoridad.
     */
    public const LEVELS = [
        'super_admin' => 1,
        'admin'       => 2,
        'supervisor'  => 3,
        'empleado'    => 4,
    ];

    /**
     * Obtiene el nivel jerárquico de un usuario.
     * Si tiene múltiples roles, retorna el de mayor autoridad (menor número).
     */
    public static function getUserLevel(User $user): int
    {
        $roles = $user->getRoleNames()->toArray();

        $minLevel = PHP_INT_MAX;
        foreach ($roles as $role) {
            $level = self::LEVELS[$role] ?? PHP_INT_MAX;
            if ($level < $minLevel) {
                $minLevel = $level;
            }
        }

        return $minLevel === PHP_INT_MAX ? PHP_INT_MAX : $minLevel;
    }

    /**
     * Retorna los nombres de los roles con nivel mayor (menos poder)
     * que el nivel dado.
     */
    public static function getRolesBelowLevel(int $authLevel): array
    {
        return array_keys(array_filter(
            self::LEVELS,
            fn (int $level) => $level > $authLevel
        ));
    }

    /**
     * Retorna todos los nombres de roles con nivel menor o igual al dado.
     * Útil para saber qué roles puede ASIGNAR un usuario.
     */
    public static function getRolesAtOrBelowLevel(int $authLevel): array
    {
        return array_keys(array_filter(
            self::LEVELS,
            fn (int $level) => $level >= $authLevel
        ));
    }
}

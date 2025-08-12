<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class RoleRedirectHelper
{
    /**
     * Get the appropriate dashboard URL based on user role
     *
     * @param \App\Models\User|null $user
     * @return string
     */
    public static function getDashboardRoute($user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }

        if (!$user) {
            return route('login');
        }

        $roles = $user->roles_array;

        // Verificar roles en orden de prioridad
        if (in_array('ADMIN', $roles)) {
            return route('dashboard'); // Panel admin backend
        }

        if (in_array('VENDEDOR', $roles)) {
            return route('vendedor.dashboard');
        }

        if (in_array('CLIENTE', $roles) || in_array('MEMBER', $roles)) {
            return route('front-profile'); // Panel del cliente
        }

        // Por defecto al perfil
        return route('front-profile');
    }

    /**
     * Redirect user to their appropriate dashboard after login
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function redirectToDashboard($user = null)
    {
        return redirect()->to(self::getDashboardRoute($user));
    }

    /**
     * Check if user should have access to admin panel
     *
     * @param \App\Models\User|null $user
     * @return bool
     */
    public static function canAccessAdminPanel($user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }

        if (!$user) {
            return false;
        }

        $roles = $user->roles_array;
        return in_array('ADMIN', $roles) || in_array('VENDEDOR', $roles);
    }

    /**
     * Check if user should have access to seller panel
     *
     * @param \App\Models\User|null $user
     * @return bool
     */
    public static function canAccessSellerPanel($user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }

        if (!$user) {
            return false;
        }

        $roles = $user->roles_array;
        return in_array('VENDEDOR', $roles);
    }

    /**
     * Get navigation items based on user role
     *
     * @param \App\Models\User|null $user
     * @return array
     */
    public static function getNavigationItems($user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }

        if (!$user) {
            return [];
        }

        $roles = $user->roles_array;
        $navigation = [];

        // Items comunes para todos los usuarios logueados
        $navigation[] = [
            'name' => 'Mi Perfil',
            'route' => 'front-profile',
            'icon' => 'user',
        ];

        // Items específicos para administradores
        if (in_array('ADMIN', $roles)) {
            $navigation[] = [
                'name' => 'Panel Administrativo',
                'route' => 'dashboard',
                'icon' => 'settings',
            ];
        }

        // Items específicos para vendedores
        if (in_array('VENDEDOR', $roles)) {
            $navigation[] = [
                'name' => 'Panel Vendedor',
                'route' => 'vendedor.dashboard',
                'icon' => 'chart-bar',
            ];
            $navigation[] = [
                'name' => 'Mis Ventas',
                'route' => 'vendedor.sales',
                'icon' => 'clipboard-list',
            ];
            $navigation[] = [
                'name' => 'Paquetes',
                'route' => 'vendedor.packages',
                'icon' => 'map',
            ];
        }

        return $navigation;
    }

    /**
     * Get role display name in Spanish
     *
     * @param string $role
     * @return string
     */
    public static function getRoleDisplayName($role)
    {
        $roleNames = [
            'ADMIN' => 'Administrador',
            'VENDEDOR' => 'Vendedor',
            'CLIENTE' => 'Cliente',
            'MEMBER' => 'Cliente', // Legacy compatibility
        ];

        return $roleNames[$role] ?? 'Cliente';
    }

    /**
     * Get role badge color class
     *
     * @param string $role
     * @return string
     */
    public static function getRoleBadgeClass($role)
    {
        $colors = [
            'ADMIN' => 'bg-red-500',
            'VENDEDOR' => 'bg-orange-500',
            'CLIENTE' => 'bg-blue-500',
            'MEMBER' => 'bg-blue-500', // Legacy compatibility
        ];

        return $colors[$role] ?? 'bg-gray-500';
    }
}

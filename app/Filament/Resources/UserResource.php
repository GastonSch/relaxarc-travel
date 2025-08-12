<?php

namespace App\Filament\Resources;

use Closure;
use App\Models\User;
use Filament\Tables;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\CreateUser;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Gestión Administrativa';

    protected static ?string $recordRouteKeyName = 'username';

    protected static ?string $modelLabel = 'Usuario';
    
    protected static ?string $pluralModelLabel = 'Usuarios';

    public static function getBreadcrumb(): string
    {
        return __('app.admin.manage_users');
    }

    protected static function getNavigationLabel(): string
    {
        return __('app.admin.users');
    }

    public static function getEloquentQuery(): Builder
    {
        // Removemos el filtro que excluía al usuario actual para poder ver todos los usuarios
        // Solo mantener si realmente necesitamos excluir al usuario loggeado
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('app.fields.name'))
                            ->required()
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(function (Closure $set, string $state) {
                                return $set('username', function () use ($state) {
                                    $state = Str::of($state)->slug('');
                                    return User::where('username', $state)->first()
                                        ? $state . rand(11, 99)
                                        : $state;
                                });
                            })
                            ->disabled(fn (Page $livewire): bool => $livewire instanceof EditUser),
                        TextInput::make('username')
                            ->label(__('app.fields.username'))
                            ->required()
                            ->maxLength(255)
                            ->disabled(),
                        TextInput::make('email')
                            ->label(__('app.fields.email'))
                            ->email()
                            ->required()
                            ->unique('users', 'email', ignoreRecord: true)
                            ->disabled(fn (Page $livewire): bool => $livewire instanceof EditUser),
                        TextInput::make('phone')
                            ->label(__('app.fields.phone'))
                            ->required()
                            ->minLength(10)
                            ->maxLength(12)
                            ->unique('users', 'phone', ignoreRecord: true)
                            ->disabled(fn (Page $livewire): bool => $livewire instanceof EditUser),
                        TextInput::make('role')
                            ->label(__('app.fields.roles'))
                            ->default(__('app.roles.staff'))
                            ->disabled()
                            ->hidden(fn (Page $livewire): bool => $livewire instanceof EditUser)
                            ->dehydrated(false),
                        Select::make('roles')
                            ->label(__('app.fields.roles'))
                            ->required()
                            ->multiple()
                            ->options([
                                'SUPERADMIN' => __('app.roles.superadmin'),
                                'ADMIN' => __('app.roles.admin'),
                                'MEMBER' => __('app.roles.member'),
                            ])
                            ->rules(['array', 'in:ADMIN,SUPERADMIN,MEMBER'])
                            ->hidden(fn (Page $livewire): bool => $livewire instanceof CreateUser)
                            ->dehydrated(fn (Page $livewire): bool => !$livewire instanceof CreateUser),
                        Textarea::make('address')
                            ->required()
                            ->label(__('app.fields.address'))
                            ->minLength(10)
                            ->disabled(fn (Page $livewire): bool => $livewire instanceof EditUser),
                        Radio::make('status')
                            ->label(__('app.fields.status'))
                            ->required()
                            ->options([
                                'ACTIVE' => __('app.status.active'),
                                'NONE' => __('app.status.inactive')
                            ])
                            ->required(fn (Page $livewire): bool => $livewire instanceof EditUser)
                            ->hidden(fn (Page $livewire): bool => $livewire instanceof CreateUser)
                            ->dehydrated(fn (Page $livewire): bool => !$livewire instanceof CreateUser),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('app.fields.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('username')
                    ->label(__('app.fields.username'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('app.fields.email'))
                    ->searchable(),
                BadgeColumn::make('roles')
                    ->label(__('app.fields.roles'))
                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            return collect($state)->map(function ($role) {
                                return match($role) {
                                    'SUPERADMIN' => __('app.roles.superadmin'),
                                    'ADMIN' => __('app.roles.admin'),
                                    'MEMBER' => __('app.roles.member'),
                                    default => $role
                                };
                            })->join(', ');
                        }
                        return $state;
                    })
                    ->colors([
                        'danger' => fn ($state) => is_array($state) && in_array('SUPERADMIN', $state),
                        'success' => fn ($state) => is_array($state) && in_array('ADMIN', $state),
                        'primary' => fn ($state) => is_array($state) && in_array('MEMBER', $state),
                    ]),
                BadgeColumn::make('status')
                    ->label(__('app.fields.status'))
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->icons([
                        'heroicon-o-check' => 'ACTIVE',
                        'heroicon-o-x' => 'NONE'
                    ])
                    ->colors([
                        'success' => 'ACTIVE',
                        'danger' => 'NONE'
                    ])
                    ->formatStateUsing(fn (string $state) => match($state) {
                        'ACTIVE' => __('app.status.active'),
                        'NONE' => __('app.status.inactive'),
                        default => $state
                    })

            ])
            ->filters([
                SelectFilter::make('roles')
                    ->label(__('app.fields.roles'))
                    ->options([
                        '["SUPERADMIN"]' => __('app.roles.superadmin'),
                        '["ADMIN"]' => __('app.roles.admin'),
                        '["MEMBER"]' => __('app.roles.member'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn (Builder $query, $value): Builder => $query->where('roles', 'LIKE', "%{$value}%"),
                        );
                    }),
                SelectFilter::make('status')
                    ->label(__('app.fields.status'))
                    ->options([
                        'ACTIVE' => __('app.status.active'),
                        'NONE' => __('app.status.inactive')
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record:username}'),
            'edit' => Pages\EditUser::route('/{record:username}/edit'),
        ];
    }

    public static function getUser(): User
    {
        return auth()->user();
    }
}

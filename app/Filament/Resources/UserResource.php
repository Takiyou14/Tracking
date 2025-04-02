<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->minLength(9)
                    ->maxLength(13),
                Forms\Components\Select::make('role')
                    ->required()
                    ->options([
                        'admin' => 'Admin',
                        'employee' => 'Employee',
                        'traveler' => 'Traveler',
                    ])
                    ->default('employee')
                    ->native(false),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->revealable()
                    ->visibleOn(('create'))
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'admin' => 'success',
                        'employee' => 'warning',
                        'traveler' => 'gray',
                    }),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->getStateUsing(fn($record) => !is_null($record->email_verified_at)),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('email_verified_at')
                    ->label('Verified')
                    ->toggle()
                    ->query(fn(Builder $query): Builder => $query->whereNot('email_verified_at', null)),
                Tables\Filters\SelectFilter::make('role')
                    ->multiple()
                    ->options([
                        'admin' => 'Admin',
                        'employee' => 'Employee',
                        'traveler' => 'Traveler',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }

}

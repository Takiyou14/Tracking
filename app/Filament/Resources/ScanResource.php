<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScanResource\Pages;
use App\Filament\Resources\ScanResource\RelationManagers;
use App\Models\Scan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScanResource extends Resource
{
    protected static ?string $model = Scan::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('package_id')
                    ->label('Package Number')
                    ->required()
                    ->placeholder('Enter package number')
                    ->uuid()
                    ->length(36),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('package_id')
                    ->label('Package Number')
                    ->limit(15)
                    ->tooltip(fn($record) => $record->package_id)
                    ->copyable()
                    ->extraAttributes([
                        'class' => 'font-mono text-sm'
                    ])
                    ->icon('heroicon-o-document-duplicate')
                    ->iconPosition('after')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Employee')
                    ->visible(fn(): bool => auth()->user()->isAdmin())
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'registered' => 'gray',
                        'taken' => 'warning',
                        'security_checked' => 'warning',
                        'loaded' => 'warning',
                        'arrived' => 'success',
                    }),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Time')
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListScans::route('/'),
            'create' => Pages\CreateScan::route('/create'),
            'edit' => Pages\EditScan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->isAdmin()) {
            return $query;
        }

        return $query->where('user_id', auth()->id());
    }

    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin() || auth()->user()->isEmployee();
    }

    public static function canCreate(): bool
    {
        return auth()->user()->isEmployee();
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->isAdmin();
    }
}

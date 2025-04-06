<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Filament\Resources\PackageResource\RelationManagers;
use App\Filament\Resources\PackageResource\RelationManagers\ScansRelationManager;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'registered' => 'Registered',
                        'taken' => 'Taken',
                        'security_checked' => 'Security_checked',
                        'loaded' => 'Loaded',
                        'arrived' => 'Arrived',
                    ])
                    ->default('registered')
                    ->native(false)
                    ->visibleOn('edit')
                    ->visible(fn(): bool => auth()->user()->isAdmin()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Tracking Code')
                    ->copyable()
                    ->extraAttributes([
                        'class' => 'font-mono text-sm'
                    ])
                    ->icon('heroicon-o-document-duplicate')
                    ->iconPosition('after'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User Name')
                    ->sortable()
                    ->searchable()
                    ->visible(fn(): bool => auth()->user()->isAdmin()),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'registered' => 'gray',
                        'taken' => 'warning',
                        'security_checked' => 'warning',
                        'loaded' => 'warning',
                        'arrived' => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\Action::make('generateQrCode')
                    ->icon('heroicon-o-qr-code')
                    ->label('Qr Code')
                    ->color('success')
                    ->modalHeading(false)
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->modalWidth('lg')
                    ->extraModalWindowAttributes([
                        'style' => 'background:white; color:black',
                    ])
                    ->modalContent(function ($record) {
                        $text = route('scan', $record->id);
                        $qrCode = QrCode::size(256)->generate($text);

                        return view('qrcode', [
                            'uuid' => $record->id,
                            'qrCode' => $qrCode,
                        ]);
                    })
                    ->extraModalFooterActions([
                        Tables\Actions\Action::make('donwload')
                            ->extraAttributes([
                                'style' => '
                                    background-color: black;
                                    margin: 0 auto;
                                    padding: 0.5rem 1.5rem;
                                    border-radius: 0.25rem;
                                '
                            ])
                            ->action(function ($record) {
                                $text = route('scan', $record->id);
                                $qrCode = QrCode::size(300)->generate($text);

                                return response()->streamDownload(function () use ($qrCode) {
                                    echo $qrCode;
                                }, 'package-' . $record->id . '.svg');
                            }),
                    ]),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            ScansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
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
        return auth()->user()->isAdmin() || auth()->user()->isTraveler();
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Admin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('email_verified_at'),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->required(),
                        Forms\Components\TextInput::make('bio')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('approved')
                            ->required(),
                        Forms\Components\Toggle::make('admin')
                            ->required(),
                        Forms\Components\Checkbox::make('change_password')
                            ->label('Change Password')
                            ->visible(fn (Forms\Get $get): bool => $get('change_password') || $form->getOperation() === 'edit')
                            ->reactive(),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->visible(fn (Forms\Get $get): bool => $get('change_password') || $form->getOperation() === 'create')
                            ->required(fn (Forms\Get $get): bool => $get('change_password') || $form->getOperation() === 'create')
                            ->rules([
                                Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(),
                            ])
                            ->confirmed(),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->visible(fn (Forms\Get $get): bool => $get('change_password') || $form->getOperation() === 'create')
                            ->required(fn (Forms\Get $get): bool => $get('change_password') || $form->getOperation() === 'create')
                            ->password(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('bio')
                    ->searchable(),
                Tables\Columns\IconColumn::make('approved')
                    ->boolean(),
                Tables\Columns\IconColumn::make('admin')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
}

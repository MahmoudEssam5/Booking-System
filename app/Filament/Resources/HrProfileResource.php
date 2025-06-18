<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HrProfileResource\Pages;
use App\Filament\Resources\HrProfileResource\RelationManagers;
use App\Models\HrProfile;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HrProfileResource extends Resource
{
    protected static ?string $model = HrProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'HR Profiles';

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        if ($user->role == 'hr_manager') {
            return parent::getEloquentQuery()
                ->where('user_id', auth()->id());
        }
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        $user = auth()->user();
        return $form
            ->schema([
                Hidden::make('user_id')
                    ->default($user->id),
                Forms\Components\TextInput::make('department'),
                Forms\Components\TextInput::make('position'),
                Forms\Components\Textarea::make('bio'),
                Forms\Components\FileUpload::make('profile_image')->image(),
                Forms\Components\TextInput::make('booking_link_slug'),
                Forms\Components\Textarea::make('notification_preferences')->json(),
                Forms\Components\TextInput::make('timezone'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('department'),
                TextColumn::make('position'),
                TextColumn::make('bio'),
                ImageColumn::make('profile_image')
                    ->disk('public'),
                TextColumn::make('booking_link_slug'),
                TextColumn::make('notification_preferences'),
                TextColumn::make('timezone'),
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
            'index' => Pages\ListHrProfiles::route('/'),
            'create' => Pages\CreateHrProfile::route('/create'),
            'edit' => Pages\EditHrProfile::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlotsResource\Pages;
use App\Filament\Resources\SlotsResource\RelationManagers;
use App\Models\AvailabilitySlot;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
class SlotsResource extends Resource
{
    protected static ?string $model = AvailabilitySlot::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected  static ?string $navigationLabel = 'Availability Slots';

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        if ($user->role == 'hr_manager') {
            return parent::getEloquentQuery()
                ->where('hr_user_id', auth()->id());
        }
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('hr_user_id')->default(auth()->id()),
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\DateTimePicker::make('start_datetime')->required(),
                Forms\Components\DateTimePicker::make('end_datetime')->required(),
                Forms\Components\TextInput::make('duration_minutes')->numeric()->required(),
                Forms\Components\Select::make('location')
                    ->options([
                        'office' => 'Office',
                        'remote' => 'Remote',
                        'hybrid' => 'Hybrid']),
                Forms\Components\Select::make('interview_type')
                    ->options([
                       'initial' =>'Initial',
                        'technical' =>'Technical',
                        'final' => 'Final'
                    ]),
                Forms\Components\Textarea::make('description'),
                Toggle::make('is_recurring')
                    ->label('Is Recurring')
                    ->reactive(),

                Textarea::make('recurring_pattern')
                    ->label('Recurring Pattern (JSON)')
                    ->json()
                    ->visible(fn ($get) => $get('is_recurring') === true),

                Forms\Components\Toggle::make('is_active')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hr.name')->label('HR Name'),
                TextColumn::make('title'),
                TextColumn::make('start_datetime')->dateTime(),
                TextColumn::make('end_datetime')->dateTime(),
                TextColumn::make('duration_minutes'),
                TextColumn::make('location'),
                TextColumn::make('interview_type'),
                ToggleColumn::make('is_recurring'),
                ToggleColumn::make('is_active'),

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
            'index' => Pages\ListSlots::route('/'),
            'create' => Pages\CreateSlots::route('/create'),
            'edit' => Pages\EditSlots::route('/{record}/edit'),
        ];
    }

}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Section::make()
                    ->schema([
                        TexTInput::make('hr_user_id'),
                        TextInput::make('slot_id'),
                        TextInput::make('candidate_name'),
                        TextInput::make('candidate_email'),
                        TextInput::make('candidate_phone'),
                        TextInput::make('position_applied'),
                        Select::make('interview_type')
                            ->options([
                                'initial' =>'Initial',
                                'technical' =>'Technical',
                                'final' => 'Final'
                            ]),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'cancelled' => 'Cancelled',
                            ]),
                        TextInput::make('candidate_notes'),
                        TextInput::make('hr_notes'),
                        Hidden::make('booking_token'),
                        TextInput::make('confirmed_at'),
                        TextInput::make('cancelled_at'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slot.title'),
                TextColumn::make('candidate_name'),
                TextColumn::make('position_applied'),
                TextColumn::make('candidate_email'),
                TextColumn::make('candidate_phone'),
                TextColumn::make('interview_type'),
                SelectColumn::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                    ]),
                TextColumn::make('candidate_notes'),
                TextColumn::make('hr_notes'),
                TextColumn::make('booking_token'),
                TextColumn::make('confirmed_at'),
                TextColumn::make('cancelled_at'),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}

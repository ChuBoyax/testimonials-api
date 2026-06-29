<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('role'),
                TextInput::make('social')
                    ->label('Social profile (FB / IG / LinkedIn / TikTok)')
                    ->helperText('Submitted by the visitor to prove they are a real person.')
                    ->maxLength(255),
                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->default(5),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('approved')
                    ->required(),
            ]);
    }
}

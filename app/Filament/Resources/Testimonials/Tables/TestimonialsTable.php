<?php

namespace App\Filament\Resources\Testimonials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('role')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('social')
                    ->label('Social')
                    ->url(fn ($state) => $state && str_starts_with($state, 'http') ? $state : null)
                    ->openUrlInNewTab()
                    ->copyable()
                    ->color('info')
                    ->placeholder('—')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('rating')
                    ->formatStateUsing(fn ($state) => str_repeat('★', (int) $state))
                    ->color('warning')
                    ->sortable(),
                TextColumn::make('message')
                    ->limit(50)
                    ->wrap(),
                ToggleColumn::make('approved'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('approved')
                    ->label('Approval status')
                    ->placeholder('All')
                    ->trueLabel('Approved')
                    ->falseLabel('Pending'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

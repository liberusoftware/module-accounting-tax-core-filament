<?php

declare(strict_types=1);

use Filament\Panel;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Liberu\Accounting\TaxCoreFilament\Resources\TaxRuleResource;
use Liberu\Accounting\TaxCoreFilament\Resources\TaxRuleResource\Pages\ListTaxRules;
use Liberu\Accounting\TaxCoreFilament\TaxCoreFilamentPlugin;
use Liberu\Accounting\TaxCoreFilament\TaxCoreFilamentServiceProvider;

it('registers and configures accounting-tax-core-filament filament resources', function (): void {
    $provider = $this->app->register(TaxCoreFilamentServiceProvider::class, force: true);
    if (method_exists($provider, 'boot')) { $provider->boot(); }
    expect($provider)->toBeInstanceOf(TaxCoreFilamentServiceProvider::class);
    $plugin = TaxCoreFilamentPlugin::make();
    $panel = Panel::make()->id('test-accounting-tax-core-filament');
    $plugin->register($panel);
    $plugin->boot($panel);
    expect($plugin->getId())->toBeString()->not->toBeEmpty();
    $host = new ListTaxRules;
    expect(TaxRuleResource::getPages())->toBeArray();
    expect(TaxRuleResource::form(Schema::make($host)))->toBeInstanceOf(Schema::class);
    expect(TaxRuleResource::table(Table::make($host)))->toBeInstanceOf(Table::class);
});

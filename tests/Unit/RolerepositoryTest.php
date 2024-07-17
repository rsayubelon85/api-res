<?php


use App\Repositories\RoleRepository;
use PHPUnit\Framework\TestCase;
use Spatie\Permission\Models\Role;

class RolerepositoryTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    public function testCreateRole()
    {
        $role = [
            'name' => 'organizador',
            'guard_name' => 'api',
        ];

        $roleRepository = new RoleRepository();
        dd('llegue');
        $roleNew = $roleRepository->create($role);

        $this->assertInstanceOf(Role::class, $roleNew);
        $this->assertEquals($role['name'], $roleNew->name);
        $this->assertEquals($roleNew['guard_name'], $roleNew->guard_name);

    }

    /*public function testUpdateCurrency()
    {
        $currencyExits = Currency::factory()->create();
        $currencyRepository = new CurrencyRepository($currencyExits);

        $currencyExits->name = 'rublo';
        $currencyExits->currency_base = 0;

        $currencyUpdated = $currencyRepository->update($currencyExits);

        $this->assertInstanceOf(Currency::class, $currencyUpdated);
        $this->assertEquals($currencyExits->name, $currencyUpdated->name);
        $this->assertEquals($currencyExits->currency_base, $currencyUpdated->currency_base);
    }

    public function testDeleteCurrency()
    {
        $currencyExist = Currency::factory()->create();

        $currencyRepository = new CurrencyRepository($currencyExist);
        $currencyRepository->delete($currencyExist);

        $this->assertDatabaseMissing('currencies', ['id' => $currencyExist->id]);
    }

    public function testFindCurrency()
    {
        $currencyExist = Currency::create([
            'name' => 'libra',
            'currency_base' => 0,
        ]);
        $currencyRepository = new CurrencyRepository($currencyExist);
        $currencyFind = $currencyRepository->getById($currencyExist->id);

        $this->assertInstanceOf(Currency::class, $currencyFind);
        $this->assertEquals($currencyExist->name, $currencyFind->name);
    }

    public function testFindCantCurrencyBase()
    {
        $cantCurrencyBase = 1;

        $currencyRepository = new CurrencyRepository();

        $this->assertEquals($cantCurrencyBase, $currencyRepository->getCantCurrencyBase());
    }

    public function testFindCantCurrencyPriRate()
    {
        $plan = Plan::factory()->create();

        $currencyPri = Currency::find($plan->primary_currency_id);

        $currencyRepository = new CurrencyRepository($currencyPri);

        $this->assertInstanceOf(Plan::class, $plan);
        $this->assertEquals(1, $currencyRepository->getCantCurrencyPri());
    }

    public function testFindCantCurrencySecRate()
    {
        $plan = Plan::factory()->create();

        $currencyPri = Currency::find($plan->secondary_currency_id);

        $currencyRepository = new CurrencyRepository($currencyPri);

        $this->assertInstanceOf(Plan::class, $plan);
        $this->assertEquals(1, $currencyRepository->getCantCurrencySec());
    }

    public function testFindCurrencyByName()
    {
        $currency = Currency::factory()->create();

        $currencyRepository = new CurrencyRepository();

        $currencyNew = $currencyRepository->getByName($currency->name);

        $this->assertInstanceOf(Currency::class, $currencyNew);
        $this->assertEquals($currency->id, $currencyNew->id);
    }*/
}

<?php

declare(strict_types=1);

namespace Jonat\Homeowners\Tests;

use Jonat\Homeowners\Person;
use PHPUnit\Framework\TestCase;

final class PersonTest extends TestCase
{
    public function testConstructorSetsAllProperties(): void
    {
        $person = new Person(
            title: 'Mr',
            first_name: 'John',
            initial: null,
            last_name: 'Smith',
        );

        $this->assertEquals('Mr', $person->title);
        $this->assertEquals('John', $person->first_name);
        $this->assertNull($person->initial);
        $this->assertEquals('Smith', $person->last_name);
    }

    public function testConstructorWithInitial(): void
    {
        $person = new Person(
            title: 'Mr',
            first_name: null,
            initial: 'F',
            last_name: 'Fredrickson',
        );

        $this->assertEquals('Mr', $person->title);
        $this->assertNull($person->first_name);
        $this->assertEquals('F', $person->initial);
        $this->assertEquals('Fredrickson', $person->last_name);
    }

    public function testConstructorWithOnlyTitleAndLastName(): void
    {
        $person = new Person(
            title: 'Mr',
            first_name: null,
            initial: null,
            last_name: 'Smith',
        );

        $this->assertEquals('Mr', $person->title);
        $this->assertNull($person->first_name);
        $this->assertNull($person->initial);
        $this->assertEquals('Smith', $person->last_name);
    }

    public function testJsonSerializeReturnsCorrectArray(): void
    {
        $person = new Person(
            title: 'Mrs',
            first_name: 'Jane',
            initial: null,
            last_name: 'Smith',
        );

        $result = $person->jsonSerialize();

        $this->assertIsArray($result);
        $this->assertEquals('Mrs', $result['title']);
        $this->assertEquals('Jane', $result['first_name']);
        $this->assertNull($result['initial']);
        $this->assertEquals('Smith', $result['last_name']);
    }

    public function testJsonSerializeWithInitial(): void
    {
        $person = new Person(
            title: 'Dr',
            first_name: null,
            initial: 'P',
            last_name: 'Gunn',
        );

        $result = $person->jsonSerialize();

        $this->assertIsArray($result);
        $this->assertEquals('Dr', $result['title']);
        $this->assertNull($result['first_name']);
        $this->assertEquals('P', $result['initial']);
        $this->assertEquals('Gunn', $result['last_name']);
    }

    public function testJsonSerializeWithNullValues(): void
    {
        $person = new Person(
            title: 'Mr',
            first_name: null,
            initial: null,
            last_name: 'Smith',
        );

        $result = $person->jsonSerialize();

        $this->assertIsArray($result);
        $this->assertEquals('Mr', $result['title']);
        $this->assertNull($result['first_name']);
        $this->assertNull($result['initial']);
        $this->assertEquals('Smith', $result['last_name']);
    }

    public function testPersonIsReadonly(): void
    {
        $person = new Person(
            title: 'Mr',
            first_name: 'John',
            initial: null,
            last_name: 'Smith',
        );

        $reflection = new \ReflectionClass($person);
        $this->assertTrue($reflection->isReadOnly());
    }

    public function testPersonImplementsJsonSerializable(): void
    {
        $person = new Person(
            title: 'Mr',
            first_name: 'John',
            initial: null,
            last_name: 'Smith',
        );

        $this->assertInstanceOf(\JsonSerializable::class, $person);
    }

    public function testPersonCanBeJsonEncoded(): void
    {
        $person = new Person(
            title: 'Mrs',
            first_name: 'Faye',
            initial: null,
            last_name: 'Hughes-Eastwood',
        );

        $json = json_encode($person, JSON_PRETTY_PRINT);

        $this->assertIsString($json);
        $this->assertStringContainsString('"title": "Mrs"', $json);
        $this->assertStringContainsString('"first_name": "Faye"', $json);
        $this->assertStringContainsString('"last_name": "Hughes-Eastwood"', $json);
    }
}

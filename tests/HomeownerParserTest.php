<?php

declare(strict_types=1);

namespace Jonat\Homeowners\Tests;

use InvalidArgumentException;
use Jonat\Homeowners\HomeownerParser;
use Jonat\Homeowners\Person;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class HomeownerParserTest extends TestCase
{
    private HomeownerParser $parser;

    protected function setUp(): void
    {
        $this->parser = new HomeownerParser();
    }

    public function testParseCsvWithValidFile(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertContainsOnlyInstancesOf(Person::class, $result);
    }

    public function testParseCsvThrowsExceptionWhenFileNotFound(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('File not found');

        $this->parser->parseCsv(__DIR__ . '/../nonexistent.csv');
    }


    public function testParseCsvWithExampleMrJohnSmith(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person = $result[0];
        $this->assertEquals('Mr', $person->title);
        $this->assertEquals('John', $person->first_name);
        $this->assertNull($person->initial);
        $this->assertEquals('Smith', $person->last_name);
    }

    public function testParseCsvWithExampleMrsJaneSmith(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person = $result[1];
        $this->assertEquals('Mrs', $person->title);
        $this->assertEquals('Jane', $person->first_name);
        $this->assertNull($person->initial);
        $this->assertEquals('Smith', $person->last_name);
    }

    public function testParseCsvWithExampleMisterJohnDoe(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person = $result[2];
        $this->assertEquals('Mr', $person->title);
        $this->assertEquals('John', $person->first_name);
        $this->assertNull($person->initial);
        $this->assertEquals('Doe', $person->last_name);
    }

    public function testParseCsvWithExampleMrBobLawblaw(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person = $result[3];
        $this->assertEquals('Mr', $person->title);
        $this->assertEquals('Bob', $person->first_name);
        $this->assertNull($person->initial);
        $this->assertEquals('Lawblaw', $person->last_name);
    }

    public function testParseCsvWithExampleMrAndMrsSmith(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person1 = $result[4];
        $this->assertEquals('Mr', $person1->title);
        $this->assertNull($person1->first_name);
        $this->assertNull($person1->initial);
        $this->assertEquals('Smith', $person1->last_name);

        $person2 = $result[5];
        $this->assertEquals('Mrs', $person2->title);
        $this->assertNull($person2->first_name);
        $this->assertNull($person2->initial);
        $this->assertEquals('Smith', $person2->last_name);
    }

    public function testParseCsvWithExampleMrCraigCharles(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person = $result[6];
        $this->assertEquals('Mr', $person->title);
        $this->assertEquals('Craig', $person->first_name);
        $this->assertNull($person->initial);
        $this->assertEquals('Charles', $person->last_name);
    }

    public function testParseCsvWithExampleMrMMackie(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person = $result[7];
        $this->assertEquals('Mr', $person->title);
        $this->assertNull($person->first_name);
        $this->assertEquals('M', $person->initial);
        $this->assertEquals('Mackie', $person->last_name);
    }

    public function testParseCsvWithExampleMrsJaneMcMaster(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person = $result[8];
        $this->assertEquals('Mrs', $person->title);
        $this->assertEquals('Jane', $person->first_name);
        $this->assertNull($person->initial);
        $this->assertEquals('McMaster', $person->last_name);
    }

    public function testParseCsvWithExampleMrTomStaffAndMrJohnDoe(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person1 = $result[9];
        $this->assertEquals('Mr', $person1->title);
        $this->assertEquals('Tom', $person1->first_name);
        $this->assertNull($person1->initial);
        $this->assertEquals('Staff', $person1->last_name);

        $person2 = $result[10];
        $this->assertEquals('Mr', $person2->title);
        $this->assertEquals('John', $person2->first_name);
        $this->assertNull($person2->initial);
        $this->assertEquals('Doe', $person2->last_name);
    }

    public function testParseCsvWithExampleDrPGunn(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person = $result[11];
        $this->assertEquals('Dr', $person->title);
        $this->assertNull($person->first_name);
        $this->assertEquals('P', $person->initial);
        $this->assertEquals('Gunn', $person->last_name);
    }

    public function testParseCsvWithExampleDrAndMrsJoeBloggs(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person1 = $result[12];
        $this->assertEquals('Dr', $person1->title);
        $this->assertEquals('Joe', $person1->first_name);
        $this->assertNull($person1->initial);
        $this->assertEquals('Bloggs', $person1->last_name);

        $person2 = $result[13];
        $this->assertEquals('Mrs', $person2->title);
        $this->assertEquals('Joe', $person2->first_name);
        $this->assertNull($person2->initial);
        $this->assertEquals('Bloggs', $person2->last_name);
    }

    public function testParseCsvWithExampleMsClaireRobbo(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person = $result[14];
        $this->assertEquals('Ms', $person->title);
        $this->assertEquals('Claire', $person->first_name);
        $this->assertNull($person->initial);
        $this->assertEquals('Robbo', $person->last_name);
    }

    public function testParseCsvWithExampleProfAlexBrogan(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person = $result[15];
        $this->assertEquals('Prof', $person->title);
        $this->assertEquals('Alex', $person->first_name);
        $this->assertNull($person->initial);
        $this->assertEquals('Brogan', $person->last_name);
    }

    public function testParseCsvWithExampleMrsFayeHughesEastwood(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person = $result[16];
        $this->assertEquals('Mrs', $person->title);
        $this->assertEquals('Faye', $person->first_name);
        $this->assertNull($person->initial);
        $this->assertEquals('Hughes-Eastwood', $person->last_name);
    }

    public function testParseCsvWithExampleMrFFredrickson(): void
    {
        $result = $this->parser->parseCsv(__DIR__ . '/../examples.csv');

        $person = $result[17];
        $this->assertEquals('Mr', $person->title);
        $this->assertNull($person->first_name);
        $this->assertEquals('F', $person->initial);
        $this->assertEquals('Fredrickson', $person->last_name);
    }

    public function testProcessNameWithSinglePerson(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('processName');
        $method->setAccessible(true);

        $result = $method->invoke($this->parser, 'Mr John Smith');

        $this->assertCount(1, $result);
        $this->assertEquals('Mr', $result[0]->title);
        $this->assertEquals('John', $result[0]->first_name);
        $this->assertEquals('Smith', $result[0]->last_name);
    }

    public function testProcessNameWithMultiplePeopleUsingAnd(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('processName');
        $method->setAccessible(true);

        $result = $method->invoke($this->parser, 'Mr Tom Staff and Mr John Doe');

        $this->assertCount(2, $result);
        $this->assertEquals('Tom', $result[0]->first_name);
        $this->assertEquals('Staff', $result[0]->last_name);
        $this->assertEquals('John', $result[1]->first_name);
        $this->assertEquals('Doe', $result[1]->last_name);
    }

    public function testProcessNameWithMultiplePeopleUsingAmpersand(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('processName');
        $method->setAccessible(true);

        $result = $method->invoke($this->parser, 'Dr & Mrs Joe Bloggs');

        $this->assertCount(2, $result);
        $this->assertEquals('Dr', $result[0]->title);
        $this->assertEquals('Mrs', $result[1]->title);
    }

    public function testProcessNameWithSharedNamePattern(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('processName');
        $method->setAccessible(true);

        $result = $method->invoke($this->parser, 'Mr and Mrs Smith');

        $this->assertCount(2, $result);
        $this->assertEquals('Mr', $result[0]->title);
        $this->assertEquals('Smith', $result[0]->last_name);
        $this->assertEquals('Mrs', $result[1]->title);
        $this->assertEquals('Smith', $result[1]->last_name);
    }

    public function testSplitNamesWithSingleName(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('splitNames');
        $method->setAccessible(true);

        $result = $method->invoke($this->parser, 'Mr John Smith');

        $this->assertCount(1, $result);
        $this->assertEquals('Mr John Smith', $result[0]);
    }

    public function testSplitNamesWithAndSeparator(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('splitNames');
        $method->setAccessible(true);

        $result = $method->invoke($this->parser, 'Mr Tom Staff and Mr John Doe');

        $this->assertCount(2, $result);
        $this->assertEquals('Mr Tom Staff', trim($result[0]));
        $this->assertEquals('Mr John Doe', trim($result[1]));
    }

    public function testSplitNamesWithAmpersandSeparator(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('splitNames');
        $method->setAccessible(true);

        $result = $method->invoke($this->parser, 'Dr & Mrs Joe Bloggs');

        $this->assertCount(2, $result);
        $this->assertStringContainsString('Dr', $result[0]);
        $this->assertStringContainsString('Mrs', $result[1]);
    }

    public function testBuildPersonWithFullName(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('buildPerson');
        $method->setAccessible(true);

        $result = $method->invoke($this->parser, 'Mr John Smith');

        $this->assertInstanceOf(Person::class, $result);
        $this->assertEquals('Mr', $result->title);
        $this->assertEquals('John', $result->first_name);
        $this->assertEquals('Smith', $result->last_name);
    }

    public function testBuildPersonWithInitial(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('buildPerson');
        $method->setAccessible(true);

        $result = $method->invoke($this->parser, 'Mr M Mackie');

        $this->assertInstanceOf(Person::class, $result);
        $this->assertEquals('Mr', $result->title);
        $this->assertNull($result->first_name);
        $this->assertEquals('M', $result->initial);
        $this->assertEquals('Mackie', $result->last_name);
    }

    public function testBuildPersonWithInitialWithPeriod(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('buildPerson');
        $method->setAccessible(true);

        $result = $method->invoke($this->parser, 'Mr F. Fredrickson');

        $this->assertInstanceOf(Person::class, $result);
        $this->assertEquals('Mr', $result->title);
        $this->assertNull($result->first_name);
        $this->assertEquals('F', $result->initial);
        $this->assertEquals('Fredrickson', $result->last_name);
    }

    public function testBuildPersonWithLastNameOnly(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('buildPerson');
        $method->setAccessible(true);

        $result = $method->invoke($this->parser, 'Mr Smith');

        $this->assertInstanceOf(Person::class, $result);
        $this->assertEquals('Mr', $result->title);
        $this->assertNull($result->first_name);
        $this->assertNull($result->initial);
        $this->assertEquals('Smith', $result->last_name);
    }

    public function testBuildPersonWithHyphenatedLastName(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('buildPerson');
        $method->setAccessible(true);

        $result = $method->invoke($this->parser, 'Mrs Faye Hughes-Eastwood');

        $this->assertInstanceOf(Person::class, $result);
        $this->assertEquals('Mrs', $result->title);
        $this->assertEquals('Faye', $result->first_name);
        $this->assertEquals('Hughes-Eastwood', $result->last_name);
    }

    public function testBuildPersonReturnsNullForEmptyString(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('buildPerson');
        $method->setAccessible(true);

        $result = $method->invoke($this->parser, '');

        $this->assertNull($result);
    }

    public function testBuildPersonReturnsNullForInvalidTitle(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('buildPerson');
        $method->setAccessible(true);

        $result = $method->invoke($this->parser, 'Invalid John Smith');

        $this->assertNull($result);
    }

    public function testGetTitleWithValidTitles(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('getTitle');
        $method->setAccessible(true);

        $this->assertEquals('Mr', $method->invoke($this->parser, 'Mr'));
        $this->assertEquals('Mr', $method->invoke($this->parser, 'mr'));
        $this->assertEquals('Mr', $method->invoke($this->parser, 'Mister'));
        $this->assertEquals('Mrs', $method->invoke($this->parser, 'Mrs'));
        $this->assertEquals('Ms', $method->invoke($this->parser, 'Ms'));
        $this->assertEquals('Dr', $method->invoke($this->parser, 'Dr'));
        $this->assertEquals('Prof', $method->invoke($this->parser, 'Prof'));
    }

    public function testGetTitleReturnsNullForInvalidTitle(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('getTitle');
        $method->setAccessible(true);

        $this->assertNull($method->invoke($this->parser, 'Invalid'));
        $this->assertNull($method->invoke($this->parser, 'Sir'));
    }

    public function testLooksLikeInitialWithSingleLetter(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('looksLikeInitial');
        $method->setAccessible(true);

        $this->assertTrue($method->invoke($this->parser, 'M'));
        $this->assertTrue($method->invoke($this->parser, 'F'));
        $this->assertTrue($method->invoke($this->parser, 'P'));
        $this->assertTrue($method->invoke($this->parser, 'M.'));
        $this->assertTrue($method->invoke($this->parser, 'F.'));
    }

    public function testLooksLikeInitialWithMultipleLetters(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('looksLikeInitial');
        $method->setAccessible(true);

        $this->assertFalse($method->invoke($this->parser, 'John'));
        $this->assertFalse($method->invoke($this->parser, 'AB'));
        $this->assertFalse($method->invoke($this->parser, '123'));
    }

    public function testLooksLikeInitialWithNonAlpha(): void
    {
        $reflection = new ReflectionClass($this->parser);
        $method = $reflection->getMethod('looksLikeInitial');
        $method->setAccessible(true);

        $this->assertFalse($method->invoke($this->parser, '1'));
        $this->assertFalse($method->invoke($this->parser, '@'));
    }
}

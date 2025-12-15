<?php

declare(strict_types=1);

namespace Jonat\Homeowners;

final class HomeownerParser
{
    private const TITLE_MAP = [
        'mr' => 'Mr',
        'mrs' => 'Mrs',
        'ms' => 'Ms',
        'dr' => 'Dr',
        'prof' => 'Prof',
        'mister' => 'Mr',
    ];

    /**
     * @return array<Person>
     */
    public function parseCsv(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("File not found: {$filePath}");
        }

        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            throw new \RuntimeException("Could not open file: {$filePath}");
        }

        $results = [];
        fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            if (!isset($row[0]) || $row[0] === '') {
                continue;
            }

            $name = trim($row[0]);
            $persons = $this->processName($name);
            $results = array_merge($results, $persons);
        }

        fclose($handle);

        return $results;
    }

    /**
     * @return array<Person>
     */
    private function processName(string $name): array
    {
        if (preg_match('/^(Mr|Mrs|Ms|Dr|Prof|Mister)\s+(and|&)\s+(Mr|Mrs|Ms|Dr|Prof|Mister)\s+(.+)$/i', $name, $m) !== 0) {
            $t1 = $this->getTitle($m[1]);
            $t2 = $this->getTitle($m[3]);
            $shared = trim($m[4]);

            if ($t1 !== null && $t2 !== null) {
                $p1 = $this->buildPerson($t1 . ' ' . $shared);
                $p2 = $this->buildPerson($t2 . ' ' . $shared);

                if ($p1 !== null && $p2 !== null) {
                    return [$p1, $p2];
                }
            }
        }

        $parts = $this->splitNames($name);
        $output = [];

        foreach ($parts as $part) {
            $person = $this->buildPerson(trim($part));
            if ($person !== null) {
                $output[] = $person;
            }
        }

        return $output;
    }

    /**
     * @return array<string>
     */
    private function splitNames(string $name): array
    {
        if (preg_match('/\s+and\s+/i', $name) !== 0) {
            $result = preg_split('/\s+and\s+/i', $name);
            if ($result === false) {
                return [$name];
            }
            return $result;
        }

        if (preg_match('/\s+&\s+/', $name) !== 0) {
            $result = preg_split('/\s+&\s+/', $name);
            if ($result === false) {
                return [$name];
            }
            return $result;
        }

        return [$name];
    }

    private function buildPerson(string $name): ?Person
    {
        $name = trim($name);
        if ($name === '') {
            return null;
        }

        $parts = preg_split('/\s+/', $name);
        if ($parts === false || $parts === []) {
            return null;
        }

        $title = $this->getTitle($parts[0]);
        if ($title === null) {
            return null;
        }

        array_shift($parts);

        if ($parts === []) {
            return null;
        }

        if ($this->getTitle($parts[0]) !== null) {
            $title = $this->getTitle($parts[0]);
            array_shift($parts);
        }

        if ($parts === []) {
            return null;
        }

        $count = count($parts);

        if ($count === 1) {
            return new Person(
                title: $title,
                first_name: null,
                initial: null,
                last_name: $parts[0],
            );
        }

        if ($count === 2) {
            $first = $parts[0];
            $last = $parts[1];

            if ($this->looksLikeInitial($first)) {
                return new Person(
                    title: $title,
                    first_name: null,
                    initial: strtoupper(rtrim($first, '.')),
                    last_name: $last,
                );
            }

            return new Person(
                title: $title,
                first_name: $first,
                initial: null,
                last_name: $last,
            );
        }

        $first = $parts[0];
        $last = $parts[$count - 1];
        $middle = array_slice($parts, 1, -1);

        $initial = null;
        $first_name = null;

        if ($this->looksLikeInitial($first)) {
            $initial = strtoupper(rtrim($first, '.'));
        } else {
            $first_name = $first;
        }

        if ($initial === null && $middle !== []) {
            $mid = implode(' ', $middle);
            if ($this->looksLikeInitial($mid)) {
                $initial = strtoupper(rtrim($mid, '.'));
            }
        }

        return new Person(
            title: $title,
            first_name: $first_name,
            initial: $initial,
            last_name: $last,
        );
    }

    private function getTitle(string $word): ?string
    {
        return self::TITLE_MAP[strtolower($word)] ?? null;
    }

    private function looksLikeInitial(string $word): bool
    {
        $clean = rtrim($word, '.');
        return strlen($clean) === 1 && ctype_alpha($clean);
    }
}

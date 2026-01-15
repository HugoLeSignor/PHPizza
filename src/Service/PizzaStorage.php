<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class PizzaStorage
{
    private string $storagePath;
    private Filesystem $filesystem;

    public function __construct(KernelInterface $kernel)
    {
        $this->filesystem = new Filesystem();
        $this->storagePath = $kernel->getProjectDir() . '/var/pizzas.json';
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getAll(): array
    {
        $this->ensureStorage();

        $raw = file_get_contents($this->storagePath);
        if ($raw === false) {
            return [];
        }

        $decoded = json_decode($raw, true) ?? [];

        return is_array($decoded) ? $decoded : [];
    }

    public function addPizza(string $name, string $specialIngredient): void
    {
        $this->ensureStorage();

        $name = trim($name);
        $specialIngredient = trim($specialIngredient);

        if ($name === '' || $specialIngredient === '') {
            throw new \InvalidArgumentException('Le nom et l\'ingrédient secret sont obligatoires.');
        }

        $pizzas = $this->getAll();

        foreach ($pizzas as $pizza) {
            if (strcasecmp($pizza['specialIngredient'], $specialIngredient) === 0) {
                throw new \InvalidArgumentException('Cet ingrédient secret est déjà utilisé par une autre pizza.');
            }
        }

        $pizzas[] = [
            'id' => uniqid('pz_', true),
            'name' => $name,
            'specialIngredient' => $specialIngredient,
            'createdAt' => (new \DateTimeImmutable())->format(\DateTimeInterface::ATOM),
        ];

        $this->write($pizzas);
    }

    private function ensureStorage(): void
    {
        $directory = dirname($this->storagePath);
        if (!$this->filesystem->exists($directory)) {
            $this->filesystem->mkdir($directory);
        }

        if (!$this->filesystem->exists($this->storagePath)) {
            $seed = [
                [
                    'id' => uniqid('pz_', true),
                    'name' => 'Pizza au beurre de cacahuette',
                    'specialIngredient' => 'Pastèque',
                    'createdAt' => (new \DateTimeImmutable())->format(\DateTimeInterface::ATOM),
                ]
            ];

            $this->write($seed);
        }
    }

    /**
     * @param array<int, array<string, string>> $pizzas
     */
    private function write(array $pizzas): void
    {
        file_put_contents($this->storagePath, json_encode($pizzas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR), LOCK_EX);
    }
}

<?php declare(strict_types=1);

namespace RimiItk\Timestuff;

use Symfony\Component\OptionsResolver\OptionsResolver;

class TimeStuff
{
    private array $options;

    public function __construct(array $options)
    {
        $this->options = $this->resolveOptions($options);
    }

    /**
     * Compute expiration time closest to but after “now".
     */
    public function getExpirationTime(\DateTimeImmutable $now = new \DateTimeImmutable())
    {
        $times = [];
        foreach ($this->options['expiration_times'] as $spec) {
            try {
                $time = $now->modify($spec);
                if ($time > $now) {
                    $times[] = $time;
                }
            } catch (\Exception $exception) {
                // Ignore any exceptions.
            }
        }

        return empty($times) ? null : min([...$times]);
    }

    private function resolveOptions(array $options)
    {
        return (new OptionsResolver())
            ->setRequired('expiration_times')
            ->setAllowedTypes('expiration_times', 'string[]')
            ->resolve($options);
    }
}

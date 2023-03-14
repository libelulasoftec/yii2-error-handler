<?php

namespace Libelulasoft\ErrorHandler\interfaces;

interface ConfigRecord
{

    public function getConfig(string $code): array;
}

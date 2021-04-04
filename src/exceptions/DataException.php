<?php

namespace taguz91\ErrorHandler\exceptions;

interface DataException
{

  public function getDataError(): array;
}

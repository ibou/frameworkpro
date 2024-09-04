<?php

return new class
{
  public function up(): void
  {
    echo get_class($this) . ' "up" method called 2' . PHP_EOL;
  }

  public function down(): void
  {
    echo get_class($this) . ' "down" method called 2' . PHP_EOL;
  }
};

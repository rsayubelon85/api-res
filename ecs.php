<?php
use CodelyTv\CodingStyle;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([__DIR__ . '/app',]);
    $ecsConfig->paths([__DIR__ . '/database',]);
    $ecsConfig->paths([__DIR__ . '/test',]);
    $ecsConfig->paths([__DIR__ . '/routes',]);

    $ecsConfig->sets([CodingStyle::DEFAULT]);
};

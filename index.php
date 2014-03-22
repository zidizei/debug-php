<?php

require 'vendor/autoload.php';

\Debug\profile("testInfo");

usleep(1000);
\Debug\debug("test");

\Debug\profile("asd");

usleep(1000);
\Debug\warn("test");

\Debug\profile();


\Debug\profile();

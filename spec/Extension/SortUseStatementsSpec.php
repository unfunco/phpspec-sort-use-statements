<?php

/*
 * Copyright 2018 Daniel Morris
 * https://unfun.co
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at:
 *
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace spec\Unfunco\PhpSpec\Extension;

use PhpSpec\Extension;
use PhpSpec\ObjectBehavior;
use Unfunco\PhpSpec\Extension\SortUseStatements;

final class SortUseStatementsSpec extends ObjectBehavior
{
    function it_is_an_extension()
    {
        $this->shouldImplement(Extension::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SortUseStatements::class);
    }
}

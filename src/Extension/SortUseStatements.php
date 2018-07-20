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

namespace Unfunco\PhpSpec\Extension;

use PhpSpec\CodeGenerator\Generator\NewFileNotifyingGenerator;
use PhpSpec\CodeGenerator\Generator\SpecificationGenerator as OriginalSpecificationGenerator;
use PhpSpec\Extension;
use PhpSpec\ServiceContainer;
use PhpSpec\ServiceContainer\IndexedServiceContainer;
use ReflectionClass;
use Unfunco\PhpSpec\Generator\TypedSpecification as TypedSpecificationGenerator;

class SortUseStatements implements Extension
{
    /**
     * Loads the override specification generator.
     *
     * @param ServiceContainer $container Service container.
     * @param array            $params    Parameters.
     *
     * @return void
     */
    public function load(ServiceContainer $container, array $params)
    {
        $container->define('code_generator.generators.specification', function (IndexedServiceContainer $c) {
            $originalSpecificationGenerator = new ReflectionClass(OriginalSpecificationGenerator::class);
            $reflectedRenderTemplateMethod = $originalSpecificationGenerator->getMethod('renderTemplate');
            [$_, $filePath] = $reflectedRenderTemplateMethod->getParameters();

            if (null !== $filePath->getType()) {
                /** @noinspection PhpParamsInspection */
                $specificationGenerator = new TypedSpecificationGenerator(
                    $c->get('console.io'),
                    $c->get('code_generator.templates'),
                    $c->get('util.filesystem'),
                    $c->get('process.executioncontext')
                );
            } else {
                /** @noinspection PhpParamsInspection */
                $specificationGenerator = new \Unfunco\PhpSpec\Generator\UntypedSpecification(
                    $c->get('console.io'),
                    $c->get('code_generator.templates'),
                    $c->get('util.filesystem'),
                    $c->get('process.executioncontext')
                );
            }

            /** @noinspection PhpParamsInspection */
            return new NewFileNotifyingGenerator(
                $specificationGenerator,
                $c->get('event_dispatcher'),
                $c->get('util.filesystem')
            );
        }, ['code_generator.generators']);
    }
}

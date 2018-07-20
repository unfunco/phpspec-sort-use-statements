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

namespace Unfunco\PhpSpec\Generator;

use PhpSpec\CodeGenerator\Generator\PromptingGenerator;
use PhpSpec\Locator\Resource;
use PhpSpec\ObjectBehavior;

class UntypedSpecification extends PromptingGenerator
{
    /**
     * Returns a boolean indicative of the generation type being supported.
     *
     * @param Resource $resource   Class and specification information.
     * @param string   $generation Generation type.
     * @param array    $data       Arbitrary data.
     *
     * @return bool
     */
    public function supports(Resource $resource, $generation, array $data): bool
    {
        return 'specification' === $generation;
    }

    /**
     * Returns the extension priority.
     *
     * @return int
     */
    public function getPriority(): int
    {
        return 0;
    }

    /**
     * Returns the path to the specification.
     *
     * @param Resource $resource Class and specification information.
     *
     * @return string
     */
    protected function getFilePath(Resource $resource): string
    {
        return $resource->getSpecFilename();
    }

    /**
     * Renders the specification template.
     *
     * @param Resource $resource Class and specification information.
     * @param string   $filePath Path to the file requiring generation.
     *
     * @return string
     */
    protected function renderTemplate(Resource $resource, $filePath): string
    {
        $values = [
            '%filepath%' => $filePath,
            '%name%' => $resource->getSpecName(),
            '%namespace%' => $resource->getSpecNamespace(),
            '%subject%' => $resource->getSrcClassname(),
            '%subject_class%' => $resource->getName(),
            '%use%' => $this->buildUseStatements([
                $resource->getSrcClassname(),
                ObjectBehavior::class,
            ]),
        ];

        if (!$content = $this->getTemplateRenderer()->render('specification', $values)) {
            $content = $this->getTemplateRenderer()->renderString($this->getTemplate(), $values);
        }

        return $content;
    }

    /**
     * Returns the message indicating a successfully generated specification.
     *
     * @param Resource $resource Class and specification information.
     * @param string   $filePath Path to the generated specification.
     *
     * @return string
     */
    protected function getGeneratedMessage(Resource $resource, $filePath): string
    {
        return sprintf(
            '<info>Specification for <value>%s</value> created in <value>%s</value>.</info>%s',
            $resource->getSrcClassname(),
            $filePath,
            PHP_EOL
        );
    }

    /**
     * Returns the default template content.
     *
     * @return string
     */
    private function getTemplate(): string
    {
        return <<< TEMPLATE
<?php

namespace %namespace%;

%use%

final class %name% extends ObjectBehavior
{
    function it_is_initializable()
    {
        \$this->shouldHaveType(%subject_class%::class);
    }
}

TEMPLATE;
    }

    private function buildUseStatements(array $classes): string
    {
        sort($classes);
        array_walk($classes, function (string &$class) {
            $class = sprintf('use %s;', $class);
        });

        return implode(PHP_EOL, $classes);
    }
}

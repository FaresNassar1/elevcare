<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    GNU General Public License v2.0
 */

namespace Juzaweb\API\Support\Documentation;

use Juzaweb\API\Support\Swagger\SwaggerDocument;
use Juzaweb\API\Support\Swagger\SwaggerMethod;
use Juzaweb\API\Support\Swagger\SwaggerPath;

class ApplicationSwaggerDocumentation implements APISwaggerDocumentation
{
    public function handle(SwaggerDocument $document): SwaggerDocument
    {
        $document->path(
            "applications",
            function (SwaggerPath $path) {
                $path->method(
                    'get',
                    function (SwaggerMethod $method) {
                        $method->operationId("admin.applications.index");
                        $method->summary("Get List of From Applications");
                        $method->tags(['Applications']);
                        $method->parameterRef('start_date');
                        $method->parameterRef('end_date');
                        $method->parameterRef('query_limit');
                        $method->responseRef(200, 'success_list');
                        return $method;

                    },
                );
                return $path;
            }
        );
        $document->path(
            "applications/{id}",
            function (SwaggerPath $path) {
                $path->method(
                    'get',
                    function (SwaggerMethod $method) {
                        $method->operationId("admin.applications.show");
                        $method->summary("Get Application");
                        $method->tags(['Applications']);
                        $method->parameterRef('path_id');
                        return $method;
                    }
                );
                return $path;
            }
        );
        return $document;

    }
}

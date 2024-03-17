# TYPO3 health checks integration

This is the TYPO3 integration of the [CMS Health Check RFC](https://github.com/cms-health-project/health-check-rfc).

The extension registers a new [reaction](https://docs.typo3.org/c/typo3/cms-reactions/main/en-us/Index.html)
`HealthCheckReaction`, which allows administrators to generate various health
check reports by selection the checks to execute and include in the
corresponding report.

The extension already provides a couple of `checks`, which are autotagged
and registered based on the implemented `CmsHealth\Definition\CheckInterface`.

A `check` can contain multiple `results`, which implemente the
`CmsHealth\Definition\CheckResultInterface` and are bundled in the
`health check`, implementing the `CmsHealth\Definition\HealthCheckInterface`.

To register a new `check`, it's sufficient to create a new class implementing
the `CmsHealth\Definition\CheckInterface`.

## Installation

Install the extension via composer `composer req o-ba/health-checks`.

Due to the underlying reactions API, the extension is only available for TYPO3
v12 upwards.

## License

The extension is licensed under GPL v2+, same as the TYPO3 Core. For details
see the [LICENSE](https://github.com/o-ba/fe-login-mode/blob/main/LICENSE)
file in this repository.

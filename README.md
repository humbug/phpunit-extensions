Humbug PHPUnit Extensions
=========================

A collection of extensions intended to allow for:
* Timing of test and testsuite execution
* Filter/Reorder tests using custom filters


Installation
============

```json
require: {
   "padraic/phpunit-extensions": "~1.0@dev"
}
```
Configuration
=============

Time Collector Listener
-----------------------

The Time Collector Listener logs timing data on tests and test suites for use
by the time dependent filters. You can enable it using the follow phpunit.xml
snippet.

```xml
  <listeners>
    <listener class="\MyBuilder\PhpunitAccelerator\TestListener">
      <arguments>
        <boolean>true</boolean>
      </arguments>
    </listener>
    <listener class="\Humbug\Phpunit\Listener\TimeCollectorListener">
      <arguments>
        <object class="\Humbug\Phpunit\Logger\JsonLogger">
          <arguments>
            <string>/path/to/times.json</string>
          </arguments>
        </object>
      </arguments>
    </listener>
  </listeners>
```
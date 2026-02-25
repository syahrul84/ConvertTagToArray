# ConvertTagToArray

A lightweight PHP utility to convert XML or HTML tags into a structured
PHP array.

This library is useful when you need to parse markup content into a
programmatically accessible format for processing, transformation, or
integration with other systems.

------------------------------------------------------------------------

## ✨ Features

-   Convert XML to PHP array
-   Convert HTML to PHP array
-   Simple and lightweight (no external dependencies)
-   Easy integration into existing PHP projects
-   Recursive parsing support

------------------------------------------------------------------------

## 📦 Installation

Clone the repository:

``` bash
git clone https://github.com/syahrul84/ConvertTagToArray.git
```

Or copy the `convertTagToArray.php` file into your project.

------------------------------------------------------------------------

## 🚀 Usage

``` php
require_once 'convertTagToArray.php';

$xml = '
<book>
    <title>Example Book</title>
    <author>John Doe</author>
</book>
';

$result = convertTagToArray($xml);

print_r($result);
```

Example output:

``` php
Array
(
    [book] => Array
        (
            [title] => Example Book
            [author] => John Doe
        )
)
```

------------------------------------------------------------------------

## 🧠 Use Cases

-   Processing external XML APIs
-   Converting HTML templates into structured data
-   Data migration tools
-   CMS or content parsing
-   Integration pipelines

------------------------------------------------------------------------

## ⚙️ Requirements

-   PHP 5.6+ (recommended PHP 7+ or newer)

------------------------------------------------------------------------

## 📁 Project Structure

    convertTagToArray.php   # Main parser function
    README.md               # Documentation

------------------------------------------------------------------------

## 🔒 Limitations

-   Not intended to replace full DOM parsers
-   Complex malformed HTML may require preprocessing
-   No namespace handling (basic parser)

------------------------------------------------------------------------

## 🛠 Future Improvements

-   Composer package support
-   Namespaced class version
-   Unit tests
-   Performance benchmarks
-   Extended attribute handling

------------------------------------------------------------------------

## 👨‍💻 Author

Syahrul Farhan

------------------------------------------------------------------------

## 📄 License

MIT License

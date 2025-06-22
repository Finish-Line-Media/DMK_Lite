# Contributing to MediaKit Lite

First off, thank you for considering contributing to MediaKit Lite! It's people like you that make MediaKit Lite such a great theme.

## Code of Conduct

By participating in this project, you are expected to uphold our Code of Conduct:

- Use welcoming and inclusive language
- Be respectful of differing viewpoints and experiences
- Gracefully accept constructive criticism
- Focus on what is best for the community
- Show empathy towards other community members

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check existing issues as you might find out that you don't need to create one. When you are creating a bug report, please include as many details as possible:

- **Use a clear and descriptive title**
- **Describe the exact steps to reproduce the problem**
- **Provide specific examples to demonstrate the steps**
- **Describe the behavior you observed after following the steps**
- **Explain which behavior you expected to see instead and why**
- **Include screenshots if applicable**
- **Include your environment details** (WordPress version, PHP version, browser, etc.)

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, please include:

- **Use a clear and descriptive title**
- **Provide a step-by-step description of the suggested enhancement**
- **Provide specific examples to demonstrate the steps**
- **Describe the current behavior and explain which behavior you expected to see instead**
- **Explain why this enhancement would be useful**

### Pull Requests

1. Fork the repo and create your branch from `main`
2. If you've added code that should be tested, add tests
3. If you've changed APIs, update the documentation
4. Ensure the test suite passes
5. Make sure your code follows WordPress coding standards
6. Issue that pull request!

## Development Setup

1. Clone the repository
```bash
git clone https://github.com/yourusername/mediakit-lite.git
cd mediakit-lite
```

2. Install dependencies (if any)
```bash
npm install
composer install
```

3. Set up a local WordPress development environment (we recommend Local by Flywheel or MAMP)

4. Create a symlink from your theme directory to WordPress themes folder
```bash
ln -s /path/to/mediakit-lite /path/to/wordpress/wp-content/themes/mediakit-lite
```

## Coding Standards

### PHP

We follow the [WordPress PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/):

- Use tabs for indentation
- Always use braces for control structures
- Yoda conditions for comparisons
- Proper spacing around operators
- Meaningful variable and function names

### CSS

- Use the BEM methodology for class names: `.mkp-component__element--modifier`
- Mobile-first responsive design
- Use CSS custom properties for theming
- Maintain consistent spacing with CSS variables

### JavaScript

- ES6+ syntax where appropriate
- Proper event handling with jQuery when needed
- Meaningful variable and function names
- Comment complex logic

## Testing

Before submitting a pull request:

1. Test in multiple browsers (Chrome, Firefox, Safari, Edge)
2. Test responsive design at various breakpoints
3. Run the theme through [Theme Check plugin](https://wordpress.org/plugins/theme-check/)
4. Ensure no PHP errors with `WP_DEBUG` enabled
5. Check accessibility with browser tools

## Commit Messages

- Use the present tense ("Add feature" not "Added feature")
- Use the imperative mood ("Move cursor to..." not "Moves cursor to...")
- Limit the first line to 72 characters or less
- Reference issues and pull requests liberally after the first line

Examples:
```
Add profile photo positioning options

- Split profile photo and family crest into separate controls
- Add left/right positioning for each image
- Update hero layout to support flexible positioning
- Fixes #123
```

## Documentation

- Update the README.md with details of changes to the interface
- Update the CHANGELOG.md following the existing format
- Comment your code where necessary
- Update inline documentation for functions and hooks

## Questions?

Feel free to open an issue with your question or contact the maintainers directly.

Thank you for contributing to MediaKit Lite!
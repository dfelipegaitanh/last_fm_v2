---
trigger: model_decision
description: When you are writing the documentation
---

# Documentation Format

When adding documentation to this guidelines:

- Use clear, concise language
- Include code examples where appropriate
- Explain the "why" behind the change, not just the "what"
- Reference related documentation or external resources when relevant
- Organize information under appropriate headings

# Documentation of Critical Enhancements

When making significant changes to the codebase, especially to critical components or core functionality, follow these guidelines:

# What to Document

- **Architectural Changes**: Any modifications to the system's architecture, design patterns, or structural components.
- **Core Algorithm Improvements**: Significant optimizations or changes to core algorithms that affect performance, security, or functionality.
- **New Design Patterns**: Introduction of new design patterns or programming paradigms.
- **Breaking Changes**: Any changes that are not backward compatible or require updates to dependent code.
- **Security Enhancements**: Important security improvements or vulnerability fixes.
- **Performance Optimizations**: Significant performance improvements that change how the system operates.

# When adding documentation

- Use clear, concise language
- Include code examples where appropriate
- Explain the "why" behind the change, not just the "what"
- Reference related documentation or external resources when relevant
- Organize information under appropriate headings

# Where to Document

## **For Critical Enhancements**:

- Record the session start timestamp in yyyy-MM-dd_hh-mm format.
- Create a file for the documentation like this {what-was-improved}-{timestamp}.md
- {timestamp} is the timestamp you create before (the actual date)
- {what-was-improved} is a tiny description of whatever it was improved
- Place detailed enhancement documentation files in the `.enhancements` directory

## **For Bug Fixes**:

- For significant bug fixes that affect core functionality or behavior
- Document the root cause of the bug and the solution implemented
- Include any lessons learned that might prevent similar bugs
- If the fix introduces a new pattern or approach, document it here
- Place detailed bug documentation files in the `.bugs` directory
- The file must have a timestamp in yyyy-MM-dd_hh-mm format at the end, example: `bugfix-2023-01-01_12-34.md`.

## **For New Features**:

- If the feature introduces new development patterns, add them to this guidelines document
- For features that require specific usage patterns, include examples
- Document any non-obvious design decisions that future developers should understand
- Place detailed feature documentation files in the `.features` directory
- - The file must have a timestamp in yyyy-MM-dd_hh-mm format at the end, example: `feature-2023-01-01_12-34.md`.

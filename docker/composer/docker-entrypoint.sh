#!/bin/bash
set -e

# Print Composer version
echo "Composer version: $(composer --version)"

# Check if the first argument is a Composer command
if composer help "$1" > /dev/null 2>&1; then
    echo "Running Composer command: $*"
    composer "$@"
else
    echo "Running custom command: $*"
    "$@"
fi

# Keep the container running
echo "Command completed. Container will remain running."
tail -f /dev/null
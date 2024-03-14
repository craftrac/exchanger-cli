#!/bin/bash

# Determine whether to use Podman or Docker
if command -v podman &>/dev/null; then
    CMD="podman"
else
    CMD="docker"
fi

# Ensure the script is called with the container name or ID and up to three optional arguments for the PHP script
# if [ $1 -eq 'help' ]; then
#     echo "Usage: $0 [arg1] [arg2] [arg3]"
#     exit 1
# fi
#
# Container name or ID is the first argument
CONTAINER_NAME_OR_ID="exchanger-cli_web_1"
# CONTAINER_NAME_OR_ID="$1"

# Command to be executed inside the container
COMMAND="php /app/index.php"

# Append up to three arguments if they are provided
if [ $# -ge 2 ]; then
    ARG1="$2"
    COMMAND+=" $ARG1"
fi

if [ $# -ge 3 ]; then
    ARG2="$3"
    COMMAND+=" $ARG2"
fi

if [ $# -eq 4 ]; then
    ARG3="$4"
    COMMAND+=" $ARG3"
fi

# Execute the command in the specified Docker container
$CMD exec "$CONTAINER_NAME_OR_ID" sh -c "$COMMAND"


#!/bin/bash

HookTarget='deploy/post-merge-run-dev'
Hooks=${1:-post-merge post-checkout}
RepoRoot=$(git rev-parse --show-toplevel)
HookDir="${RepoRoot}/.git/hooks"

echo "Creating hooks for ${Hooks} in ${HookDir} ... "

cd "${HookDir}"

for t in ${Hooks} ; do
    echo "Linking .git/hooks/${t} -> ${HookTarget}"
    ln -sf "../../${HookTarget}" "${t}"
done

echo "Linking .git/hooks/pre-commit -> deploy/pre-commit-hook"
ln -sf "../../deploy/pre-commit-hook" pre-commit

echo "Done."

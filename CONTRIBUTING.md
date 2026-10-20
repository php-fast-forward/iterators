# Contributing

Add one independent `.changelog/*.md` fragment for each observable change.
Use [Fast Forward Changelog v0.3.0](https://github.com/php-fast-forward/changelog/tree/v0.3.0)
through CPX with PHP 8.5 or newer; the package's PHP requirements stay unchanged.

```sh
cpx --skip-local fast-forward/changelog help add
cpx --skip-local fast-forward/changelog add "Describe the change." --category=fixed --no-interaction
cpx --skip-local fast-forward/changelog check --no-interaction
```

Choose the category and semantic impact that describe the change. Commit the
fragment with the contribution; leave published history intact and do not add
an `Unreleased` section to `CHANGELOG.md`. After committing, validate the PR delta
with `check --since=origin/main --source=tags --no-interaction` using the same CLI.

[The installed project skill](.agents/skills/fast-forward-changelog/SKILL.md)
explains the contribution and release lifecycle. Check its integrity with
`cpx --skip-local fast-forward/changelog skill:install --check --json`.
The skill is a local instruction payload, independent of a Composer dependency.

The GitHub workflow checks fragments, maintains PR feedback and prepares a
version PR from stable ancestral tags and committed history. Review that PR's
version, history and fragment deletions before merging it. It never merges itself;
its approved merge publishes the version tag and GitHub Release. Installing the
workflow or merging an ordinary contribution does not publish a release.

This repository has published GitHub Releases and no central changelog yet.
The workflow uses `source: github` so the first version PR imports the existing
release notes and publication dates instead of replacing them with missing-note
messages. Existing release text remains intact; a release with no notes gets an
explicit missing-notes message. New sections use Keep a Changelog headings and
version links. Fragment PR references are resolved automatically during
consolidation when their merged origin can be verified; do not invent references
for historical releases. The published GitHub Release uses the same new version
body as `CHANGELOG.md`.

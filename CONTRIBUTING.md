# Contributing

Add one independent `.changelog/*.md` fragment for each observable change.
Use [Fast Forward Changelog](https://github.com/php-fast-forward/changelog)
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

Run `composer install` to fetch the project skill into
`.agents/skills/fast-forward-changelog`. The committed `skills.json` selects its
GitHub source through `llm/skills`; generated `.agents` files stay out of Git.
This does not install Changelog's runtime dependencies into the library.
Inspect the copy with `composer skills:show` and refresh compatible versions with
`composer skills:update --from=github`. Keep the skill under this manager's
ownership; do not run the legacy Changelog skill installer on it.

The GitHub workflow checks fragments, maintains PR feedback and prepares a
version PR from stable ancestral tags and committed history. Review that PR's
version, history and fragment deletions before merging it. It never merges itself;
its approved merge publishes the version tag and GitHub Release. Installing the
workflow or merging an ordinary contribution does not publish a release.

`CHANGELOG.md` includes all three published stable versions, backfilled from
GitHub Releases with their original notes and publication dates. The workflow
uses `source: github` to retain that evidence during future consolidation.
Existing release text remains intact; a release with no notes gets an
explicit missing-notes message. New sections use Keep a Changelog headings and
version links. Fragment PR references are resolved automatically during
consolidation when their merged origin can be verified; do not invent references
for historical releases. The published GitHub Release uses the same new version
body as `CHANGELOG.md`.

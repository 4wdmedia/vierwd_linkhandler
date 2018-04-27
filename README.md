# vierwd_linkhandler
TYPO3 Linkhandlers for phone-links and pre-defined links.

## Example PageTSConfig for pre-defined links

```
TCEMAIN.linkHandler.static {
	handler = Vierwd\VierwdLinkHandler\StaticLinkHandler
	label = Pre-Defined Links
	configuration {
		links {
			imprintIdentifier {
				label = Imprint
				typolink {
					parameter = 5
				}
			}
		}
	}
	scanAfter = page
}
```
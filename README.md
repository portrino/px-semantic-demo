# Portrino Demo Website (experimental!)

This TYPO3 demo website will show some basic examples how to use [EXT:px_semantic](https://github.com/portrino/px_semantic/).
## Installation

<pre>
git clone https://github.com/portrino/px-semantic-demo.git .
</pre>

<pre>
composer install
</pre>

## Setup TYPO3

<pre>
./typo3cms install:setup
</pre>

## Setup Introduction Package

<pre>
./typo3cms extension:activate introduction
</pre>

## Run TYPO3 console stuff

<pre>
composer run-script run-typo3-console-stack
</pre>


## Configure TS

Setup:
<pre>
config {
    baseURL = 
    absRefPrefix = 
}

plugin.tx_pxsemantic.settings.rest.pid = 40
plugin.tx_news.settings.defaultDetailPid = {$plugin.tx_news.settings.defaultDetailPid}

</pre>

Constants:
<pre>
page.logo.file = 1:/introduction/images/theme/IntroductionPackage.png
page.theme.copyright.text = Proudly powered by <a href="http://www.typo3.org" target="_blank">TYPO3 CMS</a>

plugin.tx_news.settings.defaultDetailPid = 38
</pre>
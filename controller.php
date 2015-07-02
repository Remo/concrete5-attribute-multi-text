<?php

namespace Concrete\Package\AttributeMultiText;

use Concrete\Core\Backup\ContentImporter,
    Package;

class Controller extends Package
{

    protected $pkgHandle = 'attribute_multi_text';
    protected $appVersionRequired = '5.7.4';
    protected $pkgVersion = '1.0.0';

    public function getPackageName()
    {
        return t('Multi text attribute');
    }

    public function getPackageDescription()
    {
        return t('Installs a multi text attribute where you can enter several lines in a single attribute');
    }

    protected function installXmlContent()
    {
        $pkg = Package::getByHandle($this->pkgHandle);

        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/install.xml');
    }

    public function install()
    {
        $pkg = parent::install();

        $this->installXmlContent();
    }

    public function upgrade()
    {
        parent::upgrade();

        $this->installXmlContent();
    }

}
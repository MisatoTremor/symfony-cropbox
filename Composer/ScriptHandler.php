<?php
/*
 * This file is part of the MonstrumSymfonyJCrop.
 *
 * (c) Erwin Eu <eu.erwin@gmail.com>
 */
namespace Monstrum\SymfonyCropboxBundle\Composer;

use Composer\Script\Event;
use Mopa\Bridge\Composer\Util\ComposerPathFinder;
use Monstrum\SymfonyCropboxBundle\Command\SymfonyJQueryPluginSymlinkCommand;

/**
 * Script for Composer, create symlink to symfony-cropbox lib into the MonstrumSymfonyCropboxBundle.
 */
class ScriptHandler
{
    public static function postInstallSymlinkSymfonyPlugin(Event $event)
    {
        $IO = $event->getIO();
        $composer = $event->getComposer();
        $cmanager = new ComposerPathFinder($composer);
        $options = array(
            'targetSuffix' => self::getTargetSuffix(),
            'sourcePrefix' => self::getSourcePrefix()
        );
        list($symlinkTarget, $symlinkName) = $cmanager->getSymlinkFromComposer(
            SymfonyJQueryPluginSymlinkCommand::$monstrumSymfonyJQueryPluginBundleName,
            SymfonyJQueryPluginSymlinkCommand::$jcropName,
            $options
        );
        $symlinkTarget .= !empty(SymfonyJQueryPluginSymlinkCommand::$sourceSuffix) ? DIRECTORY_SEPARATOR . SymfonyJQueryPluginSymlinkCommand::$sourceSuffix : '';

        $IO->write("Checking Symlink", FALSE);
        if (false === SymfonyJQueryPluginSymlinkCommand::checkSymlink($symlinkTarget, $symlinkName, true)) {
            $IO->write("Creating Symlink: " . $symlinkName, FALSE);
            SymfonyJQueryPluginSymlinkCommand::createSymlink($symlinkTarget, $symlinkName);
        }
        $IO->write(" ... <info>OK</info>");
    }

    public static function postInstallMirrorSymfonyPluginBundle(Event $event)
    {
        $IO = $event->getIO();
        $composer = $event->getComposer();
        $cmanager = new ComposerPathFinder($composer);
        $options = array(
            'targetSuffix' =>  self::getTargetSuffix(),
            'sourcePrefix' => self::getSourcePrefix()
        );
        list($symlinkTarget, $symlinkName) = $cmanager->getSymlinkFromComposer(
            SymfonyJQueryPluginSymlinkCommand::$monstrumSymfonyJQueryPluginBundleName,
            SymfonyJQueryPluginSymlinkCommand::$pluginName,
            $options
        );
        $symlinkTarget .= !empty(SymfonyJQueryPluginSymlinkCommand::$sourceSuffix) ? DIRECTORY_SEPARATOR . SymfonyJQueryPluginSymlinkCommand::$sourceSuffix : '';

        $IO->write("Checking Mirror", FALSE);
        if (false === SymfonyJQueryPluginSymlinkCommand::checkSymlink($symlinkTarget, $symlinkName)) {
            $IO->write("Creating Mirror: " . $symlinkName, FALSE);
            SymfonyJQueryPluginSymlinkCommand::createMirror($symlinkTarget, $symlinkName);
        }
        $IO->write(" ... <info>OK</info>");
    }

    protected static function getTargetSuffix($end = "")
    {
        return DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "public" . $end;
    }

    protected static function getSourcePrefix($end = "")
    {
        return '..' . DIRECTORY_SEPARATOR . $end;
    }
}

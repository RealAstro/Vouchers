<?php


namespace notstrafes\Plugin;


use notstrafes\Loader;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;

/**
 * @property Loader plugin
 */
class VoucherListener implements Listener
{

    public function __construct(Loader $plugin) {
        $this->plugin = $plugin;
    }

    public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $tag = $item->getNamedTagEntry("voucher");
        if($tag == null){
            return;
        }
        if ($tag instanceof CompoundTag) {
            if ($tag->hasTag("rank")) {
                $rank = $tag->getString("rank");
                $this->plugin->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup {$player->getName()} $rank");
                $item->getCount() == 1 ? $player->getInventory()->setItemInHand(Item::get(Item::AIR)) : $player->getInventory()->setItemInHand($item->setCount($item->getCount() - 1));
            }
        }
    }

}
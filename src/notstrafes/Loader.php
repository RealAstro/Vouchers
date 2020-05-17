<?php


namespace notstrafes;


use notstrafes\Plugin\VoucherCommand;
use notstrafes\Plugin\VoucherListener;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase
{

    public function onEnable() {
        $this->getLogger()->info("Vouchers by NotStrafes is now enabled.");
        $this->getServer()->getCommandMap()->register("VOUCHERS", new VoucherCommand($this));
        $this->getServer()->getPluginManager()->registerEvents(new VoucherListener($this), $this);
    }

    public static function getVoucher(string $rank):Item {
        $item = Item::get(Item::PAPER);
        $item->setCustomName("§r§f§lVOUCHER:§r§a " . ucfirst($rank));
        $item->setLore([
            "§r§7Right-Click or Hold screen to redeem the",
            "§r§a{$rank}§7 Rank!",
            "",
            "§r§c§lWARNING: §r§7This item can only be used ONCE",
            "§r§7and is not able to be Refunded if Lost!"
        ]);
        $item->setNamedTagEntry(new CompoundTag("voucher"));
        $tag = $item->getNamedTagEntry("voucher");
        if ($tag instanceof CompoundTag) {
            $tag->setString("rank", $rank);
        }
        return $item;
    }

}
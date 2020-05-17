<?php


namespace notstrafes\Plugin;


use notstrafes\Loader;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\utils\TextFormat;

/**
 * @property Loader plugin
 */
class VoucherCommand extends PluginCommand
{

    public function __construct(Loader $plugin) {
        parent::__construct("voucher", $plugin);
        $this->plugin = $plugin;
        $this->setAliases(["givevoucher"]);
        $this->setDescription("Gives a player a certain rank voucher");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if (!$sender->hasPermission("voucher.command")) {
            $sender->sendMessage("§cYou do not have enough permission to execute this command!");
            return;
        }
        if (!isset($args[0]) || !isset($args[1])) {
            $sender->sendMessage("§aUsage: /voucher <player> <rank-name>");
            return;
        }
        $target = $this->plugin->getServer()->getPlayer($args[0]);
        if ($target == null) {
            $sender->sendMessage("§r§c{$args[0]} cannot be found or is offline!");
            return;
        }
        $voucher = Loader::getVoucher($args[1]);
        $target->getInventory()->addItem($voucher);
        $target->sendMessage("§aYou have been given a " . ucfirst(strtolower($args[1])) . " Voucher!");
        $sender->sendMessage("§aYou gave " . $target->getName() . " a " . ucfirst(strtolower($args[1])) . " Voucher!");
    }
}
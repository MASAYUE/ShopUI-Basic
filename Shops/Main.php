<?php namespace Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\{
  event\Listener,
  event\player\PlayerJoinEvent,
  event\player\PlayerMoveEvent,
  event\player\PlayerInteractEvent,
  event\player\PlayerJumpEvent
  };
use pocketmine\item\Item;
use pocketmine\entity\Entity;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;

use jojoe77777\FormAPI;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener{
  public $namel = "§d[ §eสมหญิง §d] §7⇥ ";
  
  public function onEnable() : void{
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  
  public function onCommand(CommandSender $sender, Command $command, String $label, array $args) : bool {
    if($command->getName() === "aid"){
      if($sender instanceof Player){
        $this->mainForm($sender);
      } else {
        $sender->sendMessage("§cกรุณาพิมพ์ในเกม");
      }
    }
    return true;
  }
  
  public function mainForm($sender){
    $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
    $form = $api->createSimpleForm(function(Player $sender, $data){
		$result = $data;
		if($result === null){
			return true;
		}
		switch($result){
			case 0:
            $sender->addTitle("§aขอบคุณที่ใช้บริการ");
            break;
            case 1:
			$item = Item::get(340,0,1);
			if($sender->getInventory()->contains($item)){
				$sender->getInventory()->addItem(Item::get(373,19,1));
				$economy = EconomyAPI::getInstance();
				$payment = 300;
				EconomyAPI::getInstance()->reduceMoney($sender->getName(), $payment, true);
				$ment = "§fเข็มดำน้ำเข็มเล็ก";
				$sender->sendMessage($this->namel."§e+ §c$payment ");
				$sender->sendMessage($this->namel."§aซือ $ment §aจำนวน §c1 §aหลอดเรียบร้อย");
			}else{
				$sender->sendMessage($this->namel."§cเงินไม่พอจ้า");
			}
			return true;
			 case 2:
			$item = Item::get(340,0,1);
			if($sender->getInventory()->contains($item)){
				$sender->getInventory()->addItem(Item::get(373,20,1));
				$economy = EconomyAPI::getInstance();
				$payment = 900;
				EconomyAPI::getInstance()->reduceMoney($sender->getName(), $payment, true);
				$ment = "§fเข็มดำน้ำเข็มใหญ่";
				$sender->sendMessage($this->namel."§e+ §c$payment ");
				$sender->sendMessage($this->namel."§aซือ $ment §aจำนวน §c1 §aหลอดเรียบร้อย");
			}else{
				$sender->sendMessage($this->namel."§cเงินไม่พอจ้า");
			}
			return true;
		}
    });
    $form->setTitle("§eสมหญิงการแพทย์");
    $form->setContent("ร้านชายยา");
    $form->addButton("§cออกจากร้านค้า",0,"textures/ui/cancel");
    $form->addButton("§aเข็มดำน้ำเข็มเล็ก\n§b1หลอด  300", 0,"textures/items/potion_bottle_waterBreathing");
    $form->addButton("§aเข็มดำน้ำเข็มใหญ่\n§b1หลอด  600", 0,"textures/items/potion_bottle_waterBreathing");
    $form->sendToPlayer($sender);
	}
}
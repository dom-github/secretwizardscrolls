<?php
session_start(); // Needed if using session to store form state

$name = "";
$formSubmitted = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));

    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Save to file (optional)
        file_put_contents("contacts.txt", "$name | $email\n", FILE_APPEND);

        // Save info to session (optional)
        $_SESSION['formSubmitted'] = true;
        $_SESSION['name'] = $name;

        // Redirect to avoid resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Read session and reset
if (isset($_SESSION['formSubmitted'])) {
    $formSubmitted = true;
    $name = $_SESSION['name'] ?? '';
    unset($_SESSION['formSubmitted'], $_SESSION['name']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://db.onlinewebfonts.com/c/8fcba25cad7e455d9c900464ec6e7fe3?family=F1499+Alde+Manuce+Pro+Normal" rel="stylesheet">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
  <title>The Wizard's Library</title>
  <style>
    
    html, body {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
      background-color: black; 
      font-size: 3.5vmin;
    }
    body {
      font-family: "F1499 Alde Manuce Pro Normal";
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
      overflow: hidden;
      position: relative;
    }
* {
  -webkit-tap-highlight-color: transparent;
}
/* Standard syntax (modern browsers) */
::placeholder {
  color: #636363; /* Change to your desired color */
  opacity: 1;  /* Firefox adds a lower opacity by default, this makes it opaque */
}

/* Chrome, Opera, Safari */
::-webkit-input-placeholder {
  color: #636363;
  opacity: 1;
}

/* Firefox 19+ */
::-moz-placeholder {
  color: #636363;
  opacity: 1;
}

/* Internet Explorer 10+ */
:-ms-input-placeholder {
  color: #636363;
  opacity: 1;
}

/* Microsoft Edge */
::-ms-input-placeholder {
  color: #636363;
  opacity: 1;
}
 /* @media only screen and (max-width: 600px) {
      html, body {
          font-size: 16px; /* Smaller font for mobile /*
      }
    } */
    .square-container {
      position: relative;
      width: 100vmin;   /* vmin is the smaller of viewport width and height */
      height: 100vmin;
      background-color: white; 
      /* Optional: add a border or box-shadow for clarity */
      box-shadow: 0 0 10px rgba(0,0,0,0.5);
      overflow: hidden;
    }
    /* Background layer */
    .background {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url('assets/img/webp/background.webp');
      background-size: cover;
      z-index: 1;
    }
    .crystalbackground {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      z-index: 1;
    }
    .inspectpage {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: scroll;
        /* Hide scrollbar for IE, Edge */
        -ms-overflow-style: none; 
        /* Hide scrollbar for Firefox */
        scrollbar-width: none; 
    }
#signup:focus {
  outline: none;
}

/* Wizard container layer */
.crystalbackground {
  position: absolute;
  width: 100%; 
  height: 100%; 
  /* You can optionally constrain the overall container size if desired */
  /* width: 800px; or similar */
}

/* Wizard container layer */
.wizard-container {
  position: absolute;
  top: 28%;
  left: 51%;
  transform: translate(-50%, -25%);
  z-index: 2;
  width: 50%; 
  height: 50%; 
  /* You can optionally constrain the overall container size if desired */
  /* width: 800px; or similar */
}


/* Remove the forced 100% rules from these classes */
.wizard-body, .wizard-hands, .crystal-ball {
  position: absolute;
  max-width: 110%;  /* You can keep this to prevent overflow if needed */
  /* Remove: width: 100%; height: 100%; */
}

@keyframes orbPonderer {
  from {transform: rotate(7deg)}
  to {transform: rotate(1deg)}
}

@keyframes orbStroke {
  from {transform: rotate(0deg) translateY(7px)}
  to {transform: rotate(1deg) translateY(0px)}
}

.wizard-hands {
  animation-name: orbPonderer;
  animation-duration: 13s;
  animation-iteration-count: infinite;
  animation-direction: alternate;
}

.wizard-finger {
  animation-name: orbStroke;
  animation-duration: 7s;
  animation-iteration-count: infinite;
  animation-direction: alternate;
}

/* Text Box Container: scales with the screen, anchored above the bottom */
.text-box {
  position: absolute;
  margin: 0px;
  padding: 0px;
  left: 5%;            /* 10% margin on left */
  width: 90%;           /* 80% of the viewport width */
  bottom: 10%;          /* Distance from the bottom (adjust as needed) */
  aspect-ratio: 4503 / 1290;   /* Adjust to your image’s intrinsic width/height ratio */
  /* If aspect-ratio isn’t supported in some browsers, you can add a fallback using a pseudo-element */
  z-index: 3;
}

/* The Background fills the entire text-box container */
.text-box-background {
  position: absolute;
  top: 0;
  left: 0;
  margin: 0px;
  padding: 0px;
  width: 100%;
  height: 100%;
  background-image: url('assets/img/webp/text_mouse.webp');
  background-size: 100% 100%;  /* Scales the image exactly to the container */
  background-repeat: no-repeat;
  pointer-events: none;        /* So that background doesn’t block any interactions */
}

/* Text Container: positioned inside the text box with a bit of padding that scales */
.text-container {
  position: absolute;
  /* Adjust these percentages to match the “printable” area inside your background image */
  top: 15%;
  left: 17%;
  width: 78%;
  height: 60%;
  line-height: 1.2;
  vertical-align: middle;
  text-align: center;
  color: #CA7231;
  margin: 0px;
  padding: 0px;
  box-sizing: border-box;
  /* border: 2.5px solid #000000; */
  scrollbar-width: none; 
  -ms-overflow-style: none;
  }
  .text-container::-webkit-scrollbar {
    display: none; /* Hides scrollbar on Chrome/Safari */
  }


/* The options-bar now acts as an aspect-ratio container anchored at the very bottom */
.options-bar {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  /* Use the aspect-ratio property (supported in modern browsers) to calculate height
     For a 5000x1667 background, the container’s height will be ~33.34% of the viewport width */
  aspect-ratio: 5000 / 907;
  z-index: 4;
  /* (For browsers that don’t support aspect-ratio, see the "fallback" comment below.) */
}


/* The background image fills the container exactly */
.options-background {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('assets/img/webp/toolbar_bg.webp');
  background-size: 100% 100%;  /* Forces the image to scale exactly with the container */
  background-position: bottom;
  z-index: 4;
}

/* Instead of using flexbox (which might not yield pixel‑perfect, absolute positions), 
   we let each button be absolutely positioned relative to the container. */
.options-buttons {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 5; /* ensure buttons are above the background */
}

/* Remove any fixed-size flex rules—and use absolute positioning for each button.
   Each button’s size and position is set in percentages so they all scale as the container scales. */
.button {
  position: absolute;
  background-size: contain;
  background-repeat: no-repeat;
  cursor: pointer;
  /* For example, if each button should be about 5% of the container's width: */
  width: 13%;
  aspect-ratio: 1 / 1; 
}


/* 
Example positions for each button – adjust these percentages to match the intended pixel‑perfect layout.
These positions are calculated relative to the container:
   - left: 0% is the left edge, and top: 0% is the top edge of the .options-bar.
*/

#option1 { left: 1%;  top: 42%; }
#option2 { left: 18%;  top: 42%; }
#option3 { left: 36%; top: 12%; width: 16%; }
#option4 { left: 54%; top: 40%; width: 12%;}
#option5 { left: 70%; top: 40%; }
#option6 { left: 86%; top: 15%; width: 16%;}

  </style>
</head>
<body>
</body>

  <script src="https://js.stripe.com/v3/"></script>
  <script>
  const tales = [`Tina the dragon was due for a bath, unquestionably. Ryan had been smelling the facts for a month now. The odours had begun as particularly perfid lasagna remnants, more specifically a pas de deux of parmiggiano romano and tomato sauce. Over the days and weeks it had transformed into something more complex, darker. Ryan had yet to smell that special maggot cheese his cousin Arnold, a gourmand, had so much spoken to him of, but he fancied Tina smelled something like it by now. <br>\
     Why had he not yet told her of this? Why had he simply spent copious amounts of time on their jungly lawn, furiously breathing in the scent of hibiscus and pomegranate, ripe? Ryan cursed his cowardice, sipped at his morning blood stew, and thought of the pear pie to come tonight. Perhaps there would be octopus pancake, with light zesty garnish, for lunch. All of it would continue to be made by Tina,  continue being the reason he stayed. <br>\
     Jenny the orangutan had not been a deficient cook, by any means, and sometimes Ryan thought about her again with a longing that had never infused their time apart when they were together. He had found her toothy grin too primitive, her luxurious tastes disturbing, her way of life too fast. In an instant she would have been like his mother, demanding too much of his time, spreading herself into every nook of his mind.      `,
`     \"I can't be whimsical!\" croaked Guiliana the Frog bitterly. Her lace veil drifted as she spoke, billowing in the biting wind. No, certainly it was not the weather to be whimsical. But she was addressing her husband, Buttigieg Bat. <br>\
     He blinked. His glasses were askew, a not—uncommon occurrence. He adjusted them with one claw, bit into a peach for comfort (he had conveniently hung himself right next to it for sleep) and decided that Guiliana's lament was not worth his time. There was still the matter of the spiders to be addressed. <br>\
     Before the conversion ceremony in the Cave of Cavernals, Buttigieg had subsisted on insects rather than fruit. Thanks to the magic words (and feathers) of the Cautious Canary, however, he could now spite earwigs and the like to his heart's content. This filled his stomach, if not his heart, for while Buttigieg had lacked the agility to grow first—rate at hunting he could easily latch on to soft round balls. The problem was the delegate of the spiders who had come yesterday with a bribe. <br>\
     \"We know you no longer eat of our kind,\" he had commenced cajolingly, \"O, Great One. And it is safe in this knowing that we come to you to seek help!\" <br>\
     Protection from a young upstart bat was what they asked for. The nerve! Buttigieg to abandon the blood ties, the bond of intra—species loyalty, in return for the mere hint or whisper of a promise to guide him to the mythical Tree of Wonders?      `,
`     Griviol was livid, as the clenching of his jaw clearly indicated to his terrified underlings. Menix, the newest hire, had not yet had the chance to mourn a relative in the wake of a Graviolian rampage. Nor were survivors so loose—lipped that Menix would find out  before his wife was eaten next year. Nevertheless, he could feel that something was in the air. He decided it was hayfever, and took an allergy pill. <br>\
     Griviol finished dumping the contents of his suitcase onto the fine Persian carpet Metina, one of the longer—lived underlings, had obtained for him following the death of her famous cat. \"None of these cigars are pyramidal in shape,\" he revealed through gritted teeth (and as some of the boxes, in fact the majority of them, were pyramidal in shape this was indeed news to his onlookers. \"Shaïfa!\" <br>\
     Shaïfa, a tall and astoundingly corpulent underling, opened his mouth in silent protest. This level of audacity in one who had seen three second cousins (one twice removed) gnashed to smithereens by Griviol was unheard of. It had the flavour of a miracle. Whispers sublity began to float about the room, rebellion to foment in unspoken argument. Then Shaïfa's fist opened to reveal a cigar rising in triangles, and the bubble of lightheartedness burst.      `,
` Nobody remembered where the Map was anymore. The Camelopard began to scramble, filled with the awful pressentiment that its diamonds would get stolen in the confusion if it stayed overlong. Then it shrieked loudly: \"Out of my manse!\" <br>\
 Its partner the owl remained nonplussed, but the cat and donkey left at that, as did the rooster. A mouse came out from under an armchair, squinting toothily. \"Did I hear something?\" <br>\
 \"Vermin,\" the owl drawled. Swooped. The mouse, more dead than alive, was in its talons. Being eaten. Eventually it would be spat out as part of a pellet. (The owl ran a healthy side business selling pellets online to amateur artists, chiefly female, of morbid predilections. <br>\
 The camelopard breathed loudly. It was calmer now that it could see its diamonds properly, without any potential thieves loitering about! <br>\
 The diamonds were a family heirloom: a religious affair, as it happened. Great—grandfather Colligit had been part of a sect which communicated with the Great World Consciousness via diamond, and the more diamond was involved, the better communication went. If the disciple had little in the way of diamond pebble, he was told to get more, to strengthen his line of connection. Unfortunately, once his bag of diamond bits reached a substantial enough weight, World Consciousness merely said \"Good.\"  `,
` \"Savoir—vivre,\" intoned the Baroness. \"Many in this institution appear to be woefully lacking.\" Her secretary, a timid—looking Italian (one could deduce his nationality from his habit of wearing loafers without socks) was jotting her words down furiously, anxious not to miss a thing. Yesterday he had missed the word \"maraschino,\" and Her Eminence* had veritably turned purple at the sight of the fresh cherry atop her crystal flute of rice pudding. The secretary, whose name was Franco, really wouldn't have minded the change of colour on its own, but the Baroness had followed it up with a disquisition on the merits of changing his employment situation. Franco had not liked that. <br>\
 * how does one address a Baroness?  `,
` The strawberry was not yet ripe, or at least it did not yet emit the sweet, sun—drenched aroma Philibert expected from small red fruit. He paused. Best leave this for Faustine, his employer's younger lover. Her palate would not be developed enough to taste the lack; she would simply be in awe of the presence of a fresh berry. Young women were so easy to impress, particularly if you had achieved any sort of success in the field they themselves hoped to break into. <br>\
 Philibert himself had hoped to become a famous chef once. He remembered the excitement of those days, the sense that nearly any encounter could bring him closer to success. Every new connection somehow taught him something new about cooking, or self—promotion, or food — the food already out there. However had he ended up in Flaubert's employ? A series of disappointments, of small capitulations to fear, had led him — irreversibly, it seemed — into the position of personal butler in a well—appointed little château (any building larger than a shed seemed to develop this title lately).  `,
` \"My mouth used to be beautiful,\" the Toucan croaked. She must have been referring to her beak, which had been a hack job at the painter's. Discolouration was not uncommon with age; appointments at the beak painter's were a hot ticket for toucans nearing the big twenty. But Mark the Hound, who was new in town, had really ruined old Martha—Toucan's decaying splendour of the mouth. He'd even gotten the colours wrong. <br>\
 \"He's a hack,\" her friend Donna agreed. Donna was a demon — retired since '09 of course, but she retained a  whiff of sulfur about her. It was her nature, and so although she was a food bank and soup kitchen volunteer of high enthusiasm nobody much enjoyed her contributions. Angels just did it better. (Thankfully they left the scent of butterscotch in their wake.)  `,
` Whispers went, passed, floated. Takira opened her eyes. The ceiling was awash with pastel hues from a great multitude of glowing crystals. Takira shut her eyes, breathed, blinked again. Nothing had changed. <br>\
 She was in a wonderfully soft bed, wearing some silken outfit. She could still hear the whispers, but they did not seem to be coming from anywhere specific. Besides, surely they didn't matter. Her new surroundings were a mystery much more absorbing. It had been a long time since Takira had seen anything comparable in the world of Man. Back in Faerie, she had been accustomed to… yet, how could this be? And why were the whispers growing so insistent, so sussurating?  `,
` Though the hour was late, the monkey was of good cheer. As per usual, it was plotting to rob its neighbour the Elephant's banana stash. Though the monkey was not entirely lacking in comestible supplies, you see, and lacked vision and excitement in its life. Consequently, it was very fond of instant gratification and petty crime alike, and mixing the two was for it the height of sweet oblivion. <br>\
 The Elephant never sought oblivion, perhaps to its detriment: it could still remember its escape from its mother's womb, and shudder with terror at the bloody thought. Fortunately, it had a predilection for vigorous activities which kept its blood flow from curdling around its hippocampus (for that is a part of the brain very important in memory retrieval, and the blood goes there just as you go to fragrant fruit trees to pluck sweet loot.)  `,
` The waters were warm in Barbados, or so Petros had been told by the Turtle, she of the giant size and delicious meat. Not that he knew what she tasted like — that would have been horribly rude — but she had told him, in bits and pieces, about the various restaurants her relatives had been served in, the personal chefs commissioned to prepare their delicious bodies for the extensively well—born of Britain, the oil magnates of Araby, the robber barons of America. Petros hadn't understood what she was saying half the time, his understanding of life thus far remaining simpler, beyond the reach of colourful figures of foreign nationalities. Except for Her, of course; the Turtle from abroad.  `,
` Nothing had been solved during the silversmiths' reunion; in fact, if Malcolm Bigpants' expression was anything to go by (and it was), Seldom H. Full's proposal continued to flail far from water. <br>\
 Nobody wanted to expand into ironwork. Morgan Dowdy expressed the sentiments of many when he snarled that he'd paid his dues in those forges, and silver was his life now. Paul Gladstone, who secretly wanted to graduate to gold filigree, had more mercenary motive, and consequently took on a highly conciliatory, flattering tone with all. Why not try mass—producing a couple of sturdy models in iron, he wheedled. It would benefit everybody. Unfortunately his speech had been sidelined by his very own poodle's innocent intestinal workings. (Paul liked to bring Macaron to work on meeting days. Attitudes toward this were, understandably, mixed.) The poop scooper, once out, much undermined the seriousness of the stakes.  `,
` \"Darling,\" Allen Castor told his young wife, not at all cordially, \"how on Earth did you manage to forget flair?\"  <br>\
 Flora hung her head. You would have thought it was her favourite parakeet's funeral (although she owned twelve, of which four were very strong contenders for \"best,\" the distinction between Pinchin and his confrères was ultimately unavoidable.) But Pinchin was still alive — she had merely disappointed her important husband, her vastly wealthier and more important that herself husband yet again. Yet again, too, in a task which he had foisted upon her without considering her interests and aptitudes. (Flora, in high school, had been especially good at football.)  `,
` Cuthbert's rags remained unscathed, a fact which unfortunately was of no relevance to the Red Pioneers' cause. Lirban's kaftan, however, had been sullied, to the great delight of — if not all — then many. <br>\
 Giovanni was about ready to weep openly. How many times had he watched these characters on TV while the call to adventure tugged at conscience and heartstrings? How much lifeblood had he poured in avoiding the call? In injury by the critical, he claimed he had been wounded; under support from the kindly, he collapsed like an overmixed soufflé. Real injury? nonsense. His pride had been bruised, perhaps. But the pride was unmerited. Never had he held steadfast. <br>\
 When did the dark times swoop down upon Giovanni? To some extent, the dark times had defined Giovanni for very long. As a child, he had been mostly waiting, and in this crouching position he had learned, enthralled, haphazardly. But now he was a very confused man, a mug of mulled wine spiced with resentment and discontent. A vague sense of having been cheated. Though he had been taught to be nice, this brought no contentment. It had been his birthright to bite. <br>\
 Cuthbert reminded Giovanni of himself. The wound was so apparent, the need to please ran so deep. Lirban, however, also felt like a reflection. The sullied glory… the outsiders gloating… And yet, perhaps this was honourable and right — a punishment just for a gambler of such disease.  `,
` The oranges, to Maximilian's great contempt and raised eyebrow, all contained worms. He spat into the crate, engulfing one wriggling figure with this machination. Maximilian's spit being extremely acidic, that worm did not persist in living much longer.  <br>\
 Having vented his spleen, Maximilian returned to his office, leaving the worms to continue their feast. <br>\
 \"Tricia,\" he said wearily to his loyal secretary. In her fifties, with a slowly expanding paunch and garish taste in makeup, Trish (as her intimates called her) could easily have aroused the scorn of the younger girls in the office by mere virtue of her appearance. But, as it happened, they lived in fear of her disapproval. Her disapproval led to quiet words to Maximilian, and unpleasant consequences followed… Last month Cordelia had returned to work with ever—dwindling amounts of fingers. One day she stopped showing up at all. Maximilian, gently smiling, said she was on leave for a salt air cure. Nobody even pretended to be deceived; it was a deafening silence.  `,
` The peacock's feathers were far too short after that trim! As a matter of fact, it was disgraceful. Perry the panda had to do something about this mishap, pronto! <br>\
 Except he was tired. And his stomach was too full. <br>\
 Lena the lizard wasn't nearly as worried as her red—furred coworker, in spite of his contagious grimaces. She was absorbed in thought of yesterday's rendez—vous with Hayden the hedgehog. What a gentleman! On twelve of his spikes he had brought her elderberries — more than what she needed for this year's wine. Perhaps she could make a second, for once… The thought was unexpected; it would never have occurred to Lena before she met Hayden. But Hayden was fond of strong cheeses, strong flavors generally, and strong wines… and this, unlike Perry's frivolous anxieties, had managed to light on fire some dry timber in her soul. <br>\
 Bern the bear, the one responsible for the peacock's unfortunate appearance, would have appreciated a cask or two of elderberry wine at that moment — no question about it. He was mad at himself for the clumsy hacking, mad at Perry for his unsubtle warning glances — ugly, bulging—eyed expressions they were! — and mad at Lena for having been lost to reverie all morning, forcing him to pick up the slack. Peacock tails were her realm of expertise, not his! What with his size, he was better suited to mammoths! Yet, and it was true, he had been grateful, just minutes ago, for the challenge…  `,
` Despair settled on the giraffe's shoulders like a pungent cheese, or rather like the aroma   `,
` The rabbit gave its paw to the turtle and said, Bite. The turtle was disgusted. Why do you do this? The rabbit let out a drunken belch and sauntered away.  `,
` The owl wondered how Hermes was doing. Lately the owl had been many things, a bewildering multitude of porcupine, pig, anthopper*, seal and parakeet (Portuguese). While Hermes had remained himself. True, he was older than the owl. True, his advanced age made it necessary for him to juggle less balloons. But, reflected the owl, did it not know of many who had perished before they could begin to wither under Nature's breath? <br>\
 Jellig the indomitable jellyfish had been such. In spite of a lack of arms or pincers, it had done its very best to pioneer in the field of juggling. With tentacles. Jellig's best attempts, against its mother's wishes, grew ever more frenzied and chaotic; eventually it burst, having worked itself up to the unheard—of: self—electrocution. <br>\
 But  Hermes was not animal often enough nowadays to be troubled by varied wishes, matchless balloons. He had made friends in the Hall of Marbles… <br>\
 * The unholy union of exactly what it sounds like.  `,
` The giraffe moaned and twisted its long neck into evidently painful positions. Now its head sprouted out of a lowercase B, now it ended an S. Jeremy sighed as he looked at his creation. It pained him to see Inch hurting himself. Perhaps animals weren't meant to be shrunk, after all. <br>\
 Centimeter the mammoth, Inch's predecessor, hadn't fared too well, either. Her fur had fallen out in stripes, she had grown listless, and within a fortnight she had dwindled away to a desiccating, fifty—millimeter—high corpse. But things would go better with Catulla, Jeremy reasoned as he poured himself a tumbler of Kraken rum (he had felt oddly drawn to nautical imagery of late). Definitely Catulla would be the cinch, the real proof—of—concept for Jeremy's Miniature MenaJerie. Her plumage was glossy, as was her mane. And, most importantly, she was the kind of animal that nobody since Bellerophon had gotten close to…  `,
` Alvin's hat was too short for much investigation. Berettas, more voluminous, were frequently vehicles for the smuggling of tiramisus these days. Alvin had been flabbergasted when he first saw an article addressing the issue. He'd had a beretta himself, once. How was tiramisu so expensive that people were risking soiling their hats to get them over the border? <br>\
 The answer lay in the price of mascarpone. Dirt—cheap in neighbouring Manca, it had risen to exhorbitant value in Pisa,  `,
` Valentina shook her silvery locks and stamped one velvet—shod foot. \"No!\", she cried, as angry as a gazelle on stampede. \"I will NOT have the crocodile over for tea!\" (By \"crocodile,\" she meant her cousin Richard, a notorious blackguard keen on addressing females as \"chickies\". He had acquired his nickname over the course of many surprise knee—and—ankle—bitings, for Richard was three.) <br>\
 Walter, the butler, would have sighed if expressing emotion was permissible. But he was mere furniture in the charmed life of little Valentina. \"Missus Valentina's presence is required for tea by the Duke and Duchess,\" he announced, placid as a saucer of cream. <br>\
 Valentina frowned. If the Duke and Duchess were involved, there was no way of wriggling out of the commitment. Her own parents were not one but two ranks lower — though her mother had once been a Marchioness, according to the mysterious whispers of her sole other cousin, Paul — and therefore would never even dream of making their betters cross. The same was not true of their daughter. It was a difficult situation. <br>\
 \"Daughter!\" the Earl of Boxham roared. His Countess was by his side, furiously fanning herself in between large gulps of suspicious—smelling tea. She hated confrontations, the poor thing, and there was simply nothing to be done when Valentina was in one of her moods. Only the Earl could handle her in those times! <br>\
 And, indeed, he was getting the paddle ready. Valentina blanched. It was a beautiful paddle, very ornate. Ivory. At various times Valentina had discerned carvings of mermaids, trolls and even a cat with a chain around its neck upon it. Generally, of course, she could feel but not see the paddle when it was in use.  `,
` Ube, Jimothy thought mournfully. However was he to grow the perfect ube? <br>\
 In the first place, he couldn't understand why the Canadian Gardeners' Association had chosen this fruit for their annual growing competition. Selection had alwaus gone like clockworl: carrot — yes, banana — no. Potato — yes, pineapple — no. Corn — yes, passionfruit — out of the question! Go to Jamaica for it! (Whether passionfruit ever had grown in Jamaica, Jimothy still did not know.) And yet. This year, pumpkin out, the Philippines in. <br>\
 Jimothy only knew about ube because during the lean years he'd stopped by a Philippino grocery store each time he had an appointment with Dr. Weatherbord, the Jewish General Hospital being at an interesting intersection of immigrants and jewry. Or at least, so Jimothy figured, given the high density of definitely Indian people and shabby specialty stores serving various Asian nationals within walking distance of a synagogue and the Segall center. The Segall was chiefly sponsored by wealthy Jews, even he knew that. But, unlike the ube situation, Jimothy had regarded the diaspora of Côte—St—Catherine with complete neutrality. There were no stakes in it for him. There was merely the possibility of purchasing a mango lassi. <br>\
 Would next year be sweetpea — no, mango — yes? Jimothy shuddered.  `,
` Garlin had a stern expression on his face. He was preparing a thundering diatribe on the degeneracy and evils of society. This type of behaviour being not uncommon in banished angels, Ligar discreetly rifled in his briefcase for an earbug. He was gently tired of banished angels at this time and would rather listen to Beethoven. Soon enough the proboscis had inserted itself into Ligar's left ear and the thundering strains of some—piece—or—other delivered themselves into his brain. The injection which made earbugs capable of this marvel dramatically reduced their lifespan, and banished them forever both from the skies and from the ranks of the beauteous wingèd, but Ligar had never doubted the injections' worth. <br>\
 Solegred, another participant of the scarcely—populated parents' meeting, was very much against the use and generation of earbugs. She had clocked Ligar's subtle operations, and the rage that had filled her immediately at the sight was frankly more effective at drowning out Garlin's rant than any insect, for while Ligar had still words about lasciviousness and promotion in public forums coming in through one ear, Solegred could think only of schemes to liberate the earbug, preferably while causing physical damage to its user's ear. She claimed to be against violence to all living beings, but such pieties she was far from extending to the Malefactors perpetually committing their wicked crimes. Yesterday she had kicked a dog beater with great relish.  `,
` What is the needful today, wondered Bell A. Rousse, cosmopolite extraordinaire, native of the world, polyglot over the tablecloth as long as you never ventured beyond dining—room topics. In short, an eccentric and a gourmand. <br>\
 Time was ticking for him on this Thursday. He was to produce a soufflé for his current wife, Walnut; moreover, it was to be flavoured with almond extract. Surely her nut fixation could have remained pinned to her namesake, carrot cake being so much easier…! But, just as there is no rest for the wicked, there is endless repose and languid daydreaming for their favored pets, and so Smyet—Ana the cat was licking herself delicately in preparation for another beautiful day.  <br>\
 Walnut, meanwhile, was out in the garden. The setting sun's rays struck her with such fervour, particularly upon her uncovered head, that she developed what used to be called a Vision. As far as Walnut could tell, a carrot—headed maiden clothed in the finest liquid amber had exited a sunray to float before her and say <br>\
 		LEAVE, O WALNUT, LEAVE! <br>\
 These words having been cast, the angel fluttered away.  `,
` The night was not so warm that the octopus could refrain from becoming a block of ice. It was against expectation, however, that it should sprout antlers as it did. The antlers were followed by a terrible cracking; the glass top of the octopus' head was rupturing, allowing a small stag to escape the confines of the frozen mollusk's body. The stag surveyed the snowy expanse tranquilly, if not quite placidly: its dark eyes were alert, you could feel it. Was it waiting for something? wondered the lone parrot conspicuously perched atop a bare birch. <br>\
 This parrot was warmer than you would expect due to the lovely thermal glass cage installed atop that bare birch. His name was Petros, in honor of that well—known saint, for his mother — who had perished that December in a carnival accident, may her soul rest eternally — had been as devout a bird as can be in Trinidad or Bogota.  `,
` \"Unquestionably this black needs a quantity of red added to it,\" said the friendly magician. He said this to no—one in particular, but both the Magpie and the Nightingale lingering in a nearby bush tittered and flew off. The magician, looking less kindly, frowned. But that did nothing to dim his kindliness in the eyes of his young model and protégée of sorts. She had a father who barely said anything at all outside of his work, which had something to do with networks and trains and drawing contests at Christmas for the children of employees, and so she always felt a profound gratitude to older men who exhibited generosity of spirit in her presence without crossing a certain physical barrier. This barrier was a colourful cage made out of Plexiglass, because the girl had failed to acquire sufficient funds for the cage to be made of the more solid and timeless stained glass. <br>\
 The magician picked up his brush again. Most of his spells were cast in this way, via wet paint. He would have been barely distinguishable from an aging painter were it not for his official guild robes, with the mandatory ten spools' worth of crimson—gold thread, and his canvas. Of course the magic would never carry if the canvas wasn't made of flayed skin and bone. <br>\
 While some loud voices had briefly made themselves heard in protest, chiefly by sullying the Wizard's Fountain with feces and urine, this custom originated in 1407 by the maverick sorcerer Tadrick quickly became tradition. The skins of leopard previously used had simply become too expensive, in 1403, with the edict on imports issued by King Megadino.  `,
` \"You might still catch a second wind,\" said the monkey teasingly to the flying squirrel, which really hadn't flown for an awfully long time, in squirrel years. Such an eternity it seemed, in fact, that the squirrel was not in the least amused, and it would have given the monkey a very wicked glare indeed were it not too well—born for such barbarities. Or could it grant itself license, just this once? No, too uncouth, it decided. Anything was better than being uncouth, old, or tawdry (the squirrel was determined to die young, so that when his corpse was examined its fur would still have lustre.) <br>\
 Regardless. The winged squirrel set fort in a sprint, jumped. Briefly it was gliding again, a marvelous feeling bursting in its chest. Then something went wrong — a wing seizing up — unnatural — sabotage! One final image floated in front of its dying eyes — of a smiling monkey proffering a bright, bright berry… <br>\
 When the soft, paralyzed body hit the ground, the monkey was jubilant.  `,
` The gnome was quite dissatisfied with the prospect from the treetops. It was not sufficient for a government official of his superior rank. Why, even the birds seemed to think so, twittering gaily to his very nose. The cheek! Wishing to give vent to his sentiments, Raphdel (for that was his name) squished a tomato. <br>\
 I must seize this moment to explain something to you. While Raphdel's action would be considered near criminal in kingdoms such as mine, wherein the cost of a bushed of tomatoes has risen to a pear of diamond, growing tomatoes is the particular specialty of gnomes. Therefore to them one fruit less or one fruit more is of no consequence. They are practically drowning in them year round. A dwarf would sooner leave his treetop naked than without, upon his personage, a tomato or two. (Raphdel's squished tomato was one of two.) <br>\
 Feeling much better, especially after having slurped up his fruit and fastidiously wiped face and fingers, Raphdel climbed down his tree. Which really was his tree, you know. When the venerable Amelia Leafborne, his mother, had learned she was to bear a son, she and her husband had found a nice plot of land exactly two villages away, as was customary, in order to plant the tree that would be his abode upon maturity. For gnomes and trees both grow very slowly, a commonality which permits this remarkable symbiosis.  `,
` Natalie could not quite place the green—eyed newcomers, although the odd question about \"poires aux gastrique\" rang a bell. They looked almost human, with long necks and knuckles dragging elegantly on the salt—stained floor. (The salt stains having come from a party of seven octopi that morning, which Natalie's coworker, Steve, had been unable to remove despite much scrubbing.)  `,
` Water dripped from the sofa onto Landon's head. This was unfortunate, but could not be helped, as Landon was a small mouse and the very large sofa had been bolted on the ceiling above him. Furthermore, Landon, being temporarily incapacitated by a sneaky injection of mescaline, could not move out of the wet sofa's shadow. Or rather, he could, but he was afraid. For the subtle substance had begun to insinuate falsehoods to him. It so happened that the floor had metamorphosed into a concentric array of rings of fire — for Landon; that the stars had become visible, the ceiling having faded away and, apparently, the day—time sky, too. A heinous Manticore, moreover, armed with a scorpion's sting and many cracked pustules upon its skin of Man, impervious to fear and fire, was advancing towards the poor drenched mouse (for the sofa was wet in reality, its position in the ceiling having come about by a foolish renter's attempt to block leakage from the top floor. Do excuse the renter — he had the skills, he had the time, having recently been fired.)  `,
` \"Some black—hearted individuals,\" the guard began to intone, \"some vermin and scoundrels—\" and here he paused for effect, but the whole impact of his creation was already, I am sorry to say, short—charged by the exceedingly grating nasal quality of his voice. <br>\
 \"Yes?\", Lord Penderlain asked quietly. This very quietness formed an undercurrent of menace which the guard really should have understood. Such comprehension would have allowed him to extend his allotted lifespan significantly. But he had always been hopeless in the subtler arts of intonation and manner, in spite of having three older sisters. Truth be told, it came down to his not being very bright. <br>\
 \"My Lord,\" the guard exclaimed, \"thieves have taken down the portrait of the Lady Enbrankd!\" <br>\
 Lord Penderlain let out a hiss. It was barely audible. \"What do I have guards for?\" <br>\
 The guard didn't understand the point of this question. \"Begging your pardon, my Lord, but what are we to do about the portrait?\" <br>\
 Penderlain did not seem to have heard the guard, which said guard found surprising, as the man was notorious for his excellent hearing faculties amongst his employees. This reputation had chiefly developed because of a series of intrusions on increasingly discreet card games. Somehow the lord had managed to glide up upon his staff gambling so often that nobody dared pull out a deck any longer.  `,
` The mode of conversation was undeniably antiquated — whoever still spoke to one another through mist or fog? And yet Phletis did so, without the slightest regret. It was by far the most sophisticated method of communication he knew: how else could one convey and colour, and smell, and words? <br>\
 \"Showing up at one's house is perfectly sufficient for that,\" snidely remarked Beryl, Phletis' Thinking—Cap. As you well know, Thinking—Caps are privy to every thought of yours as long as they remain upon your head. They can eavesdrop on your innermost questionings even from a precarious perch or rakish angle. And, perhaps because they themselves are unable to do much nestled in your hair (or, as the case might be, protecting your bald pate from the cold), Thinking—Caps are generally busy—bodies, and rude. <br>\
 Beryl was certainly no exception to this rule. But Phletis did not mind. His mother, bless her soul, had been much the same. \"It is more refined this way,\" he said mildly. \"I am certain Galatea will be pleased.\" As he said this he added two drops of almond extract to the bowl of water he had placed by his side. The bowl, being of fluted crystal, was the ideal spellcasting medium. As a matter of fact, it was one of Phletis' proudest possessions. Phletis was always very pleased with himself when he acquired beautiful objects, and arcane items in particular, for a bargain. And this bowl he had practically stolen from a roadside goblin who had barely seemed to  understand what he was holding, so inebriated was he.  `,
` The porcupine appeared to have taken ill not long before its disappearance. A thermometer lay on its bedside table, as did many an allegedly medicinal cordial. Oh, how lax the regulations had grown! Every woodtroll and his uncle sold the panacea for all earthy ills nowadays; why, you almost had to give the doctor a stern glare and pinch if she dared claim she needed more information before determining the appropriate treatment. Certainly the porcupine had been hopeful in the face of various fraudulent draughts, and who could blame it? <br>\
 Once upon a time the porcupine had needed a suit very badly, for a sweaty childhood friend of his had decided to undergo a de—sweatment procedure and in the process had miraculously been introduced to Cindy, his soon—to—be wife. I say miraculously because, when fellows in white suits are operating on your sweat glands, it is a miracle to see a pretty lady appear bearing hospital lunch. <br>\
 Particularly if the lunch involves tomato.  `,
` \"I didn't expect to see you here,\" the Genie said mildly. He looked as inoffensive and innocuous as a nine—foot—tall levitating, semi—transparent purple being ever could. King Layabout continued to eye him with suspicion nevertheless, and frankly I don't blame him. \"How would you have known of me in the first place?\", the young king queried. This purple creature was extremely unsettling, especially because he could tell it was being dishonest, but he did not know how. Sometimes young women have this sensation of speaking to a spider, when they are being flattered by a man with darker motives. But that is neither here nor there. <br>\
 The genie drew a flower of large red trumpet from behind his left ear and began idly to twirl it about. The idle manner was belied by his skillful manoeuvring — his expertise was no coincidence. \"In our ethereal realm we are privy more than you would think to the tales of men,\" the genie remarked. Layabout heard the truthfulness of this statement and prodded no further.  `,
` The dragonflies made a gentle salute in farewell. Lavinia was amazed by the graceful gesture of these insects. Her bet, however, remained on the beetles. As rare as it was for the shiny ovals to get riled up to anywhere near a competitive level, today was evidently an exceptional occasion. The royal anniversary likely had something to do with it: the Queen of Scaraby would fête her jubilee a fortnight longer still, but a win on the exact anniversary would be so wonderfully symbolic, and surely allow the team access to better funding with Her Majesty's blessing. <br>\
 Lavinia's speculations were not shared by her cousin, Steve. He was simply attending the figure flight tournament for star—crossed love reasons. It was known that Victoria, the beauteous daughter of Sir Winning Bug, had been attending the tournaments regularly of late — forced, rumor had it, by her father after a slow but steady dip in sales. Sir Bug was nothing if not an adaptable man, and any amount of daughters of his he would willingly have buried underground could it have assured his place at the top of the figure flying business. The uncertainty of it all could really eat a man alive, and so Sir Bug avoided stress like he avoided crocodiles.  `,
` \"It looks hilarious, if that was the intention,\" the Chaplain began. Having once been a man of Science, he could engage with the mode of levity more easily that those of his brothers who had always been of the Faith. He frowned now. \"But the time each of us has been granted by Our Lord is precious, and we must be sure not to waste these grains of sand on the illusory or superfluous,\" he added. Then a little girl entered the refectory, and all were discombobulated. All the men of the cloth were aflutter with apprehension, that is; the woman embroidered on the altar—piece, doubtless a Madonna, remained implacable. <br>\
 The little girl was sallow—faced but of good cheer, not unlike her ribbed turtle—neck of mustard yellow. \"This game seems very nice,\" said she to the mum onlookers. \"But I don't know the rules of it.\" Looking around, she decided to settle upon the ornate chair in front of the altar, one replete with ebony angels and little men bearing unusual pitchforks. \"Are you waiting for the Queen to join you? This is a great throne you've got here!\" <br>\
 Brother John, who had slightly more experience with such scenes from the time he had spent praying for a family of fourteen, mildly asked the little girl where she came from. \"I came from Grandmother's today,\" she answered mischievously. \"We were at the library, and then she went to the grocery store to get supper before the fireworks, but she was being so boring!\" <br>\
 Here she paused and looked ingratiatingly at Brother John, who was not at the time disposed to be merciful. \"Your grandmother  `,
` The Tickler of Navarre's growth had to be stopped. It was the epitome of an invasive breed. A once jolly name on citizens' lips had become a thrice cursed oddity, menace — even bane, to such as the Widow Gaskill. (You could tell with one look at that solemn matron swathed in black velvet that tickles had long been relegated to the catalogue of sins.) <br>\
 The whole hasty series of developments had much puzzled Jane and Kitt, those of Mr. Olyphant's brood old enough to comprehend tickling. Baby, as they still generally called the infant Brian, could still barely be touched by anybody other than their poor tired Mama, let alone tickled. But, boring Baby notwithstanding, what had happened since Daddy brought the Tickler back from France could never even have been dreamed of by either. <br>\
 And, since Kitt's Grade five teacher kept adorning his writing assignments with cheery remarks such as \"Very creative!,\" this was saying a great deal.  `,
` \"Too many nitwits here, scowled Jean Ferrars, \"and not enough experts.\" That he considered himself an unimpeachable authority was clear both from his tone and the way he held his head. He'd  have been quite amiss in the Ferrars family without its characteristic contempt for the unseemly and poor. <br>\
 But such a position was not disagreeable even to Brenda Song, deep down, head of the Socialist Tea Caddy Society thought she was. She would never have proclaimed herself one of Socialism's adoptees were it not for the fantasy that all believers in fair government were as darling and uncontroversial as she. As a matter of fact, she would have had the shock of her life to be spoken to of Socialism over anything other than tea. <br>\
 Lunar Solace, for his part, was sickened by Ferrars' little gestures of superiority, and only partly because of pretty Ms. Song's evident affinity for the man. Having been raised on a steady diet of Yeats by an imprudent father, he had come to Yorkshire with certain notions of grandeur and chivalry of which he was now thoroughly being disabused. Poor Lunar was quite determined to seek relief that night in his private diary, known as Combat Journal. It was an odd habit, to be sure, this diary—writing under so confrontational a name. But most people who had been in the army knew what he was about. Killing left one with a broken soul.  `,
` \"He needs a different haircut,\" chuckled the chimp. Indeed, the parakeet's finest hour in fashion was either far ahead or far behind. The parakeet, whose name was Tim, sighed and put his wings over his head from shame. <br>\
 But enough of the animal hair salon. What was going on at the chimps—only movie theater on Tuesday afternoon? Let's have a peek in the janitor's closet there first, if you don't mind. For in this damp enclosure one chimp was plotting his revenge…  `,
` The wizened old mage adjusted his crushed velvet pointed hat without a change to the supercilious air which had thus far been his most enduring accessory. The snakeskin boots had lasted one decade, but then the loud animal—lovers had pranced about half—naked claiming that fur and leather were not the way to live. Having enjoyed the sight of said scantily—clad protests, the mage was surprised to find he hadn't the heart to keep wearing snakeskin. <br>\
 Then there had been his bat—wing headgear. This was long enough after any kind of popular activism for him to feel comfortable wearing dead animals again; and besides, the bat—headgear had been a gift from his friend Tim, a warlock on whose insistence the mage would have been ready even to jump into a boiling cauldron. The headgear, alas, being bound by magic to its creator, went up in flames on its sesquicentennial — a year in which Tim fought a phoenix at a great disadvantage, and died charred rather than singed.  `,
` Matthias had the ball, and therefore held the key to the riddle. In this he was fortunate. Livia, having rescinded her access to the very same, was in an extremely tricky situation. To her great credit, she did not know it. <br>\
 This ignorance was to her benefit because of her congenital good fortune. Knowledge would merely have poisoned the apple of her round good cheer. <br>\
 But Matthias had the ball, and he had visited Porthello the mage to unlock its secret. Now the moment he had half—feared, half longed—for could no longer be kept at bay, lest the magicks be corrupted. Matthias  rubbed his palms against one another and began to chant the spell — <br>\
 \"Master!\" A page had just burst in through the laboratory doors, sweating like a pig. Matthias, who at the best of times was something of a neat freak, found himself utterly unable to dissemble his contempt, asking what the matter was through gritted teeth. <br>\
 \"We're out of ice cream!\", the page wailed. This was dread news indeed, for the crocodiles in the castle moat, whose protection of Matthias had proved invaluable over the past decades, could eat nothing else without developing severe indigestion. And everybody in the castle respected Matthias' motto: \"Always Be Prepared.\" (They had to, because whatever went wrong he would be sure to inflict doubly upon yourself. Nobody wished to repeat the honorably retired Chamberlain Lucius' Great Indigestion of '87.) <br>\
 Matthias scoffed. \"I'll see to it that there's an express delivery,\" he drawled.  `,
` The men were all in gold, except for one bearded oddball in a silver ballgown. Joanna did not bother to try to close her mouth, nor in any subtler way to dissemble her astonishment. The befrocked one caught her eye and winked.  <br>\
 \"Lady, we need your aid,\" spoke a man bearing a bronze trident. He smelled of the sea and bore uncut emeralds in his many ear piercings. (Joanna knew they were uncut emeralds because she had seen some at an exhibition on ancient Colombian cultures.) This speaker gave Joanna a piercing look, and the girl blushed, feeling for all the world like she had done wrong, and didn't Mr. Trident know it. <br>\
 \"But how on earth could I help you? I'm just a girl!\", exclaimed Joanna. Evidently the man with a long scroll to unroll had been prepared to address any concerns that could arise on her part. <br>\
 \"Well, as a matter of fact… Johnna, with every adherence to tenets of Sufism, you cloud our path.\" (At this he looked up from the scroll and frowned.) \"What is Sufism?\"  `,
` King Layabout scratched his head. The news from the parakeet had been quite disconcerting. Famine amongst the hedgehogs? Fights amidst the finches? General sadness, misery and woe? He wished he could ask the Thinking Cap what to do, but he really had no idea where she might have gone. <br>\
 Well, if he was to rule in his parents' absence he must start solving problems right away! Layabout jumped off the red swing and hurried about the playground, packing some of the necessaries for an adventure in his red kerchief: blocks of cheese, a spyglass, his cutlass (won in a bet against the Fred Pirate Morgan)… Layabout vaguely considered the importance of fruit and vegetable in a man's diet, then decided he would serve himself as he encountered victuals on the road. <br>\
 Ultimately he was delaying the inevitable, he realized as he plucked at his banjo. What was he to do? And in a sudden flash, he remembered his nurse's tales of the great Djinn of Alfombra…  `,
` She had always spoken of them in hushed tones.  <br>\
 Old Nadira would begin each time by speaking of the desert… <br>\
 \"Now, this here sandbox, it's OK for a prince to play in, it's safe, not too hot. The Alfombra stretches out for miles and miles. Men have died trying to cross it — fools! As if the sands would allow it. They wouldn't, you know — every grain of mice is opposed to it. For they serve the will of the Djinn…\" <br>\
 Layabout was always enthralled by the part that came next.  `,
` \"The moon is too bright,\" muttered Remigius. And indeed it was too luminous, too orb—like: its glow far exceeded the paucity required for casting a Bane of Moonshine curse. <br>\
 Yet how Remigius craved to cast such wicked magics upon his rival, young Thomas the Ancillary Astronomer! What a fitting revenge, pertaining to the heavens as it did, but above all what glorious destruction it would have wrought…! <br>\
 For, above all, Remigius envied Thomas his ease; the lightness of heart with which he consulted charts, peered through his telescope, disclosed predictions and various other actions of the sort pertaining to his métier. For Remigius, spells had never come easily: he'd rather expected to become a chef than a magician (and a court one, at that). But alas! one day his pretzel—dough pizza did not earn the distinction he'd been sure it would merit at the County Fair. Remigius did not blame his lack of advertising for the inadequacy of bums to fill seats, though he should have accorded himself that small generosity.  `,
` The kabbat stretched its cheeks out into an uneasy expression, the teeth in too horizontal a line and too exposed to be mistaken for a smile. Understandable. It was worried about the excess of goda leaves. <br>\
 The Men here came hunting for goda leaves every so often, bringing large clear bottles that made harmonious sounds when the Men struck them. And the men did this joyous hitting when their bottles were full of the dark leaves, green as Krigga frogs. It took a man about one change of the breeze clambering about the lush canopy to fill his bottle, and usually they came in two pairs, the taller group staying lower and the shorter Men going higher for reasons the kabbat did not fathom. <br>\
 But this year, the goda trees had been laden as never before with the fragrant leaves. And the Men had chosen to come in greater numbers, and eventually bearing jars not bottles, cloudy squat giants that made no melodious chimes when struck together, but a loud clang. Yet it was not the clang that bothered the kabbat so much as the behaviour of the Men who stayed behind. <br>\
 One or two always would, now. If two they were never from the same group, of course, and they went about their queer business as if they could neither see nor hear the other. Perhaps such was the case. For the Men stayed behind only if they had sneaked a chew of the leaves.  `,
` The Queen of Berring raised her brow. Sifja, her astronomer, had just given her a most unfavourable reading of Jupiter's influence on her planned war campaign. <br>\
 It was past time for hints. Sifja was a hard worker, tirelessly poring over his charts and performing calculations. But such meticulousness and, to put it bluntly, honesty did not contribute to the morale of Her Majesty's soldiers. He had been right about Venus and blindness at a crucial moment; when her men had been facing Scythians at Corinth a stampede of antelopes had worked up enough dust to panic her men, reminding them of fish—eyed Sifja's prophecy. <br>\
 \"Sifja,\" the Queen began in honeyed tones. \"Is there any way the clouding of Jupiter could be seen as dangerous for my enemies?\" <br>\
 \"No, Your Majesty,\" wheezed Sifja. The Royal Astronomer was commonly known to be a great wheezer. People assumed it was all the dust from his charts saluting him from his throat. <br>\
 It was because she was still smiling that the raised eyebrow journeying further above her left eye looked particularly menacing. \"Sifja, there is certainly one for my Royal Astronomer.\"  <br>\
 Unfortunately, Sifja did not grasp her meaning. He merely wondered whether the clouding of Jupiter might disturb the functioning of expression muscles in females. Her Majesty's left eyebrow was doing something very peculiar…  `,
` It was the end. The Bat shuddered. There was nothing left to do; the poison had taken its effect. The Bat was losing feeling in its tendons… <br>\
 Who had done it? The Bad had smelled something wrong on the mango, guessed more or less the impact of that fateful bite… Yet, he had gone through with it. Why? <br>\
 An odd sound came from the east. The Bat shuddered… it was too weak now to go lurking about, spying on mysterious strangers. One of its favourite pastimes, before… too late, why?  `,
` Once upon a time many Men had lived there. Now it welcomed grape vines in the same numbers. Speech had not been heard in the vast stone corridors for millennia. <br>\
 Zarsuk was the last Man to have mattered. It was his foolhardy will which sent the decline of that stone city, Xorthax, into motion. Glum at the mere prospect of gazing upon stars, he had decided to devote all Xorthax's resources to building that which would catapult him directly amidst the celestial orbs. <br>\
 He left the usual amount for his own welfare and upkeep, of course. A prince need not question whether his expenses are superfluous; worries do not well feed superciliousness. But Zarsuk's military was suddenly free of payment and task alike. (Every member who was not an engineer, that is). Consequently worry grew among the women and girls of the city. Especially Glihana. <br>\
 Glihana's adeptness as an orator had cost her many friends, but it was also what had kept her alive through many episodes of (well—merited) guilt, despair, anguish.  `,
` Dancing through the grove — dancing her way through the Twilig Grove, that is — Illiena was surprised at how light her heart felt. Lightning—bugs flashed their jaunty messages mere inches away as she giggled with the surge of relief. At this time she was not beholden to anyone: not snagged on foreign mistakes and griefs, not confused by anybody's hidden agenda… She could be bold, brash — even naked! Smiling as the thought occurred to her, she pulled her fox—fur cloak closer. The first real winter snows had fallen this week. Really, Illiena suddenly thought, there must be dragon's blood coursing through those little fireflies! How was it that through autumn and even now they had stayed awake?  `,
` The flower was large and fragrant; its petals, open. Sammawi would not have specified that the petals were open had the flower itself not been so unexpectedly crisp. His lieutenants had to be in on the crime, too; Sammawi's pleasure at hearing the more resonant of his underlings' prayers was much greater for prayers of thanks than for prayers of offering. The Sammawis were quick with rice and slow with everything else, including much—desired silence. <br>\
 Today Sammawi's grains had certainly turned out perfect. He wished the road home would be undertaken in silence, but that was not to be. His crafty wife kept tugging at his dark sidelock, demanding his attention for every little sight, quick to utter the little cries of praise he was meant to expand into thanksgiving prayers. But Sammawi wanted to add solitude and premium soy sauce — not his wife's foreign lolling — to the rice ceremony.  `,
` \"The truth is out,\" whispered Semiramis. The gauze bandaging her once—beautiful face fluttered as she shook her head insistently, gripped by some private sorrow. Alfiq, her physician, wondered whether he had used too little of the moth's wing ointment on Her Majesty's skin. But he wondered idly. As it happened, he knew he had been in a state of complete distraction as he tended to Semiramis' burns last night. Even now the thought that Dahlia's parents had agreed to their marriage brought joy to his mind.  `,
` The gangrene was spreading. Milo shook his head sadly. There was little that could be done by this point. Relatives could be patted on the back, gently, or some such meaningless trifle. But the gangrene meant death. It was a shame for Old Sailor Time's reputation, but they would pull through somehow. Unlike Joe. <br>\
 Milo left the room after telling his secretary how enquiries should be handled for the next couple of hours. Milo hated this mugginess, hated how scared he felt when an eerie sound erupted out of nowhere. Until it disappeared some thirty seconds later, he was deeply ill at ease, suddenly concerned that the sculpture of the Queen of Benin which ornamented his waiting—room contained some entrapped soul. He thought tiredly of his wife, who would likely be out drinking white wine with a friend on his dime at this time on a Tuesday. Whyever had he gotten the harridan pregnant; he desisted. His psychoanalyst would remind him to look inward instead of seeking a villain, as was his wont.    <br>\
 `,
` Patrick the chipmunk rode his bike, one of many. He and his friends were biking along their favourite trail in search of Amusements. The jokester of the group, Connor, had smuggled a cigar of his father's into their midst (\"Kreton's Extra—Smoky Flavour\"), but that illicit pleasure had been eclipsed by concerning realizations regarding the state of their lungs. Smoldering cigar abandoned, they had ridden off farther, half—hoping their refuse would give rise to a burning of the trail. <br>\
 Patrick felt glum, to be perfectly honest. He'd really been looking forward to that cigar, and to have it fade away into incendiary possibilities was not quite what he'd planned. A sad adieu sighed Patrick to his notions of chipmunk—shaped smoke rings! <br>\
 He was still lost in thought, pedaling along near the rear, when he heard Connor scream.  `,
` The Tweetum made its signal to the Walrus. Excited, this beast began to quiver so proudly that the gorgenberry bushes in which he was hiding trembled with a total lack of respect regarding his intention of concealment. But the harm had been done. The Shepherdess raised her head from the buttock of one worryingly flatulent sheep and peered curiously into the shaking bushes. Squirrels hereabouts were scarce, but so good in a stew… As the Shepherdess gave herself over to luxurious anticipations and the joy of the hunt, the Tweetum, deviating from the plan, charged straight for the Omulet.  `,
` The jungle permitted no mishaps, no small kindnesses. If you took the time to tell a traveler of the death behind a flower—bush, the poison frog would catch you unawares, the toucan in its rage chew your mouth off. At least back in Valencia donkeys warned one, thought Sandro bitterly. He spat out a wad of leaves, his spit red. <br>\
 What had led him to the jungle, as a lad? He thought of this as we notched an arrow to his bow, a sturdy wooden arc he'd traded a jug of beer for. Sandra recalled himself at eighteen, a wiry lad too proud for the university, too stubborn for apprenticeship. And then Uncle Pedro had come, waving his glinting rings about hypnotically as he spoke of jaguars and birds the color of rainbows. The travel—lust had burned Sandro then, cold and implacable like no lover could have been.  `,
` The cat Tabellarius stretched out belligerently on the sofa which bore many years of his markings: a chance purchase of his master's, one ill—befitting a man of his rank. It was chiefly grey, dowdy, and uncomfortably lumpy. Tabellarius had never seen fit to divert his scratchings elsewhere. <br>\
 But there was a bazaar taking place at the Roman Museum of Architecture this Saturday, and Tabellarius was determined to ferret out furniture worthy of reclination. Or to come into possession of a large enough bronze statue for the living room to put matters of reclination out of the question altogether. For he, Tabellarius, was his master's majordomo, and as such he was responsible for maintaining \"le ton,\" the standards of the place. And what a place it was, this stately marble villa! Or had been, before the resurgence of that wicked Corinna…! <br>\
 Tabellarius could see it like it had been yesterday. He yowled in anguish as he recalled the green eyes and long golden tresses of the usurper, the she—fiend!  `,
` The ground was cold. Layabout couldn't fall asleep. He wished Thinking—Cap were there with him to proffer, begrudgingly, wise advice on how to heat one's makeshift outdoor camps and soothe restlessness to make way for Sleep. But most of all he wished he knew more about Goldenrod. <br>\
 He had liked her well enough, yes, but what was he to make of the Prophecy? Surely it was insane to base the single most important choice in his life — according to what he had observed amongst the turtles — on words likely drunkenly slurred out by that old trickster Vishnevetsky! <br>\
 And yet. He paused and recalled previous days of sadness, after he had realized the matchbox filled with his precious amber pebbles had meant nothing at all to Serafina. Never had it even occurred to him that Serafina was the love of his life. He had simply been in mourning for innocence lost, illusions shattered. <br>\
 Vishnevetsky's words were not a pane of glass. They were a faded manuscript, a quizzical parchment, a feeling in his gut like a scarab beetle rummaging about. There was more here to follow. <br>\
 He dropped the warning from Serafina in his mind's eye and watched it burn. He even felt warmer.  `,
` The troll jauntily skipped along the mushroom—speckled knoll, giving nary a thought to thieving peacocks or scheming rivals. For once he was content, unconcerned, free of nagging concerns about gold pieces for his landlord (Ogre Greg) or desires to pursue attractive, yet self—obsessed and ailing troll ladies (Billie the Baleful, Dorotea the Doleful). For once…! A bluejay flitted into the branches of a pine tree (which genus was it, wondered out troll, and might it be not a pine tree after all…?), a squirrel with a nut in its mouth gave him a polite, inquisitive glance. The troll smiled at it cheerily. Then the wyrm in his left shoe chomped down on his big toe, and he knew he was in trouble. King Pritchard (\"Pritch\") had need of his services — again!  `,
` King Pritchard was an odd duck. His foul mouth came with a foul smell, owing to some abscess or other. He was perpetually harried, for no! running a kingdom was no paradise; rather, a vale of tears! No, that was not true — he was too busy for misery — in fact he was the humblest of men, referring to himself not as lord of the universe or comparable babble, but rather as a Busy Bee. <br>\
 The troll had not met King Pritchard at a happy time in his life. Troll school had been overwhelming him, and he had struggled to distinguish wealthy passersby from beggars approaching his practicum bridge — at twenty paces! His classmate Todor could have done it at fifty! It was really a disgrace, and moreover from his incompetence he'd struggled to capture enough travellers to maintain a healthy bulk. When Pritchard came upon him on that fateful Tuesday, the troll could have been mistake for a giraffe: spindly—legged, blotchy…  `,
` Trichnin wobbled on the edge of the mezzanine. His head wibbled just a bit more, being large and delicate relative to his turkey's appendage of a neck. It also woozed and gave the impression of sloshing within, or of containing subdued lappings, the skull a perfect circle of shore. For Trichnin had drunk too much yet again. <br>\
 He had not expected it to happen so quickly. Priscilla had come home bearing six (six!) decanters of wine. He had demurred, acquiesced, solemnly palmed the gold—rimmed goblets from the buffet. Over and amidst Priscilla's lack of ambition, her charmless jokes, his own vacant stupor, he had gulped the weak liquid without any rummaging for hope to speak of in those inner shores.  <br>\
 Then it had occurred to him to steal Señor Martinez' car. <br>\
 Señor Martinez was a thick—set man with eyebrows like porcupine and an angry look which seemed liable to switch to morose, lovelorn tears at the slightest provocation. He had offended Trichnin's sense of propriety last Thursday by speaking for too long with Priscilla at the nearest of their city's two luxury grocery stores. The conversation, as it were, had been a request for spare change. But Trichnin did not know that. It was better that way, Priscilla thought at the check—out, dollar bills in hand, hand in pocket on pants.  `,
` The farmers were on their way. A wave of divorces amidst their parents having obliterated their belief in commitment, they wore their hearts on their sleeves and nothing on their ring fingers. Nevertheless most of the farmers, even as they faded out of youth, seemed to have paired off. It was just that they lived separately, did not invest in wagons for two to share. Hence they were on their way by Communal CAT. <br>\
 The Carpets Automatically Trained had not been particularly popular at first. Many citizens had worried about one's inevitable proximity to the carpet's edge. So what if they were ten comrades between you and a silky corner tassel? All it took was for one individual to surprise the others, perhaps with an abrupt fainting fit or vibrant volley of recriminations. Babies were regarded with special suspicion due to their tendency for surprise grabs, fiercely dangerous reaches which could unbalance victims enough to plunge them to their doom.  `,
` The willowy lady glided in. Belinda gazed at her in awe. Here was an apparition worthy of being mummified, so to speak — embalmed between the papers of her sketching—book. Gathering her skirts up around her, she approached the hapless victim, i.e. the object of her abject fancies. <br>\
 \"Good day, milady,\" she began, quite mildly and tenderly. The lady frowned and looked up from what appeared to be an acrostic puzzle. In the brief time since Belinda had spotted her this mysterious woman had installed herself by the Portable Parakeet Parachute display case, in the giant parakeet—shaped chair Belinda had previously considered an absurd waste of money which would appeal neither to grownups nor children (it looked too disturbing; large—eyed cutesy toys were the current vogue, not this cross—eyed gawking expression). But the willowy lady, legs folded together daintily, gave the optically challenged parakeet a sense of grandeur. Abruptly Belinda remembered her husband's latest demand that she leave and bile came up in her throat.  `,
` \"I'm a fairy godmother, certified,\" said the grey—haired woman of some bulk. Her face had been hacked to a crinkle—cut by time. \"My name is Carmen.\" <br>\
 The young woman perked up at this. \"Oh, I recently learned that 'Carmen' means 'poem' in Latin!\" <br>\
 \"Yes, in the nominative and accusative cases.\"  `,
` The Harken's pace was brisk, the wind merciless: fur sprawled off the beast, seemed always but one particularly powerful gust away from independence. But the Harken, painful as this stretching of its coat was, would not stop for anything lesser than the thousand arkats the Emperor had promised him for completion of the Joal. <br>\
 Not for the first time, the Harken wondered why he had been chosen as Principal Architect. He was not renowned for his designs like Greffa the redhead had been, had not made a career out of innovation in Joals specifically, unlike Jasper (a pygmy). As a matter of facct, the Harken had never even worked on a Joal himself… merely observed the very best under construction. This, of course, had not been one of Jasper's newfangled oddities. <br>\
 It was impossible to believe that Joals had not existed but a century ago. You would be hard—pressed, in the streets, to find man or woman who had not been to Joal within at least a month. Some changed their bedsheets more often than they expressed their piousness, it was true, but few could say no unrelentingly to the prospect of free crab. <br>\
 Admiral Magin Joal had always been considered absent—minded by his crew.  `,
` Sigun followed the trail into the woods, past the weeping willow which had been his fort in times of solitude. The willow, prayer, meditations… all of these seemed so paltry now, when his life was slipping through his fingers. Sigun sighed and buried his face in his hands, covered his eyes with these loose fingers which never had to anything held on tight. <br>\
 He had lost the mansion, lost his friendships, lost his silly wife… Lost his ambitions, his convictions. He knew himself to be a shell of his former being, and longed to make the decisive move away. <br>\
 Alas, such thoughts exposed his lack of affection for his newborn son. Sigun had never imagined he could be so cruel. The child was precious, and yet very often Sigun perceived his as a mere nuisance, the fruit of a tree of sins: exceedingly easy to throw away, perhaps merely polish and give to a neighbour. Sigun was very good at being a neighbour.  `,
` The fakir's feet, legs and buttocks were all visibly pressing into the mound of steaming coals, yet he moved not an inch, indicated no discomfort whatsoever. As a matter of fact, he was smiling as beatifically as a mother whose last unmarried daughter has finally contracted an advantageous betrothal, for instance with a wealthy silk merchant or an owner of very many camels. <br>\
 Brouch did not own any camels, and as it happened the fakir's expression of contentment made him uneasy. It was proper to suffer harsh reprimands from one's master in the hopes that wages would translate into a first camel as time passed; to seek suffering purposefully, and to smile throughout as one who had drunk deep from a pitcher of good wine — this was a madness Brouch could not understand. How such cruel treatment of one's body could be meant as tribute to Allah, he failed to see. Suddenly struck with concern — this thought might be blasphemous!— Brouch prayed to the Almighty One for forgiveness. <br>\
 And yet, Brouch reflected, when he had known Nona he had acted much like this very fakir, foolishly chasing the favour of a woman whose very rank placed her out of his reach — though not the reach of his affections, as many in his town of Adabana had had cause to discover. Brouch groaned with shame at the memory of his risible proclamations to old friends: that Nona was the light of his life, the apple of his soul, the goal of all his undertakings.  `,
` Every day contained the potential for marvellous treasure to be uncovered, captured, or dredged up from the very waters of the lagoon. Kirkland had been explicit about this. And yet none of the travellers were succeeding in the discovery of coin, gem or diadem. They were growing as disillusioned as they were moth—bitten (many years ago, a local attempt at neutering moths' ransacking of closets had resulted in new competitors for mosquitos.) <br>\
 Patton, however, a solid man with a bovine chin, struck his comrades' heart with fear as well, for he had taken to snarling every once in a while at some unseen figure to \"take away the baby.\" (No baby had ever been part of the expedition, although certainly at the rate that Martha and Higmon relieved their frustrations together at night they might leave the lagoon with one in their party.)  `,
` The voice was firm and insistent. It was not audible, of course, but she felt the words all the same, and blinked her quiet assent. Yes… it was time to leave the giant squid behind.  <br>\
 She would not do so without great sorrow. She herself had begun to be gelatinous, rubbery where their flanks touched as together they would lie. But there was a whole sea full of other creatures; there were seven oceans. <br>\
 From childhood Nali had been raised by her Parrots. There had been some intervals in her hare friends' den, and a time with a smattering of confused jackals, but Nali was now a  proper judge of people.  `,
` The man's blood welled up from the gash on his thumb, a rich dark substance that made Gwenyr salivate just fine, thank you. His fangs may have been old news, but his throat would never fail to lubricate! <br>\
 And lubricate it must, for the blood of Man was different, now: gummy, mealy; a far cry from the tangy juice of Gwenyr's youth. But no matter. That Gwenyr was still there to consume it was enough. <br>\
 The terrible fight with the Manticore, initially, should not have cost Gwenyr a single fingernail. It was silly he'd agreed to it in the first place, of course, but the Manticore's nerve in questioning the vampire's promotional strategy clearly meant there was need of a reckoning. Who was this shabby beast to disparage his use of the Mirrors and insist that he perform for free? I have more concert—goers, but you could at least have more bruises, the Manticore had taunted. And Gwenyr had taken the bait. He'd had no idea — how could he? — that the Manticore had no intention of playing fair. Had never imagined it would wreathe itself in garlic. <br>\
 It had been festooned with ten metres of the bloody thing. The smell alone had nearly given Gwenyr a fit.  `,
` The theater called to Jacquin, the voices and the masks and the abject humiliation it involved. If he could do it in a manner controlled enough, if he convinced people it would distract them from their despair, it would be alright. He would even get paid. <br>\
 But Jacquin knew the other side of the coin, too. He knew his desires to excel, to fascinate, to control. It was the pendulum within him, the essence of his soul had been moulded into this form. He wondered interminably whether this was wrong, fretted and weathered storms of confusion, tempests of emotion larger than his own fragile form. <br>\
 Curtain time approached. Jacquin knew it was best to let less light in now that the child was getting drowsy. The child, chief witness of his velvet curtains, emblazoned with the suns he had lost, the moons that still struck upon his pride as martyr.  `,
` The sun had dawned upon a cleanly day. Zoraida swam into the light, movements leisurely, bathrobe diaphanous — where not embroidered with diamonds. Today, this was certain, she would unravel the mystery of the scarab scroll. <br>\
 According to certain ways of thinking, there was no question or uncertainty about the matter. The package had been delivered between the time the post office commenced its operations in the morning and nine forty AM. It had been marked FRAGILE and Zoraida had obtained it from the delivery locker marked B, down the little stairway from the general mailbox in the apartment building's entrance. This was usually strewn with discarded promotional flyers meant to persuade tenants to part with exorbitant sums of money for mediocre takeout, flyers which conspicuously few of the tenants cared to recycle despite the row of tall blue bins guarding the left flank of the ugly brick building. But, reader, what matters to us today is that Zoraida's mailbox had unexpectedly revealed the key to locker B. <br>\
 The scroll had been bubble—wrapped and stuffed into a cardboard cylinder with indecipherable writing on its bottom, smears of long—faded permanent marker indications.  `,
` The prow of the ship had been painted with an eye of Horus. This meant something which the old mariner could no longer guess or hazard. He longed to be back home, though home was no longer a trustworthy endeavor. It had not been so since his first bloom of pubescence, of smooth skin and taut bodies on the verge of growing unruly, of intrasexual competition beginning and of the Loch Ness growing forgotten. And yet there he had been raised. <br>\
 The old mariner had been happy, once. He had had a son accidentally. His name had been one letter short of the cosmos and his middle name had been Bill, like his mother's last name and his great—uncle's first one. It could have been worse, the mariner thought wryly. His other great—uncle, who had known some success curating music selection at a variety of smoky venues, had been called Toad.  `,
` Atanas' mood was foul. He did not much care for the company of crows, did not covet the grains and kernels of corn that were their favoured feed. He thought of sharks that gnawed and gnashed and never stopped moving, lest they die. <br>\
 He and Parsnip were not dissimilar to such beasts. What would happen were they to cease fighting , to breathe a moment of peace, to kick their heels away and become jackalopes? They would merely grow apart. Parsnip would tend to her root garden, play cards in the evening and occasionally stroll over to the curly—haired Valerie's for a spot of whatever accompanied their home—brewed pineapple tea.  `,
` The knitting goblin scowled. \"I've felt neither the urge nor desire to make waters large or small, ya pesterin' oaf,\" he snarled, briefly and unsuccessfully attempting to strike fear into his questioner's heart by clacking his needles in front of his  `,
` Adriana was confused by the hobgoblin's bold assertion. \"Surely you'd crack under that sort of pain,\" she countered, only half—thinking, really. Most of her was now fully absorbed in the quest for a new cigarette. She had gotten a new pair at the Hyperion yesterday, but that was of a different kind. <br>\
 With his name he sounded like he had shot from a slingshot, precisely aimed by a vicious child of an astonishing six. The children could do so much so young, Adriana mused, and sometimes so little so old.  `,
` It was always the pretty ones that got ya, reflected the postman, Steve. <br>\
 He had come to this conclusion based on limited information. Though he delivered the post to many people, he was always in such a hurry to get the assignments on time, and it was a couple of lines on the screen that told him where to go. He could have had the usual female voice to literally tell him where to go, but unfortunately for Steve that voice had sounded too much like his mother's, might she rest in peace amen. But wasn't it always the pretty ones who'd get ya. <br>\
 Unbeknownst to Steve, attractive women had reasons for approaching him that others did not. By a certain age many of this breed had, if not an exploitative understanding, then certainly a vague understanding that their wishes were likely to be fulfilled, particularly if the help involved was minimal and could be asked for kindly. Karine had probably  `,
` The hickory flower was brandished by Laura like as to a sword. \"Surrender, ye foul villain!\", she cried. The squirrel, unperturbed, continued gnawing at the apple. <br>\
 This action of the beast's was causing Laura so much grief only because it was a specially chosen extra—large Paula Red meant to take the place of supper. The hickory was in her hand because she'd read a mysterious book about flower remedies that weekend, and, if not yet ready to acquire the brandy which seemed an important ingredient in each elixir there, she'd been happy to put a name at last to the pretty blue flower still spotting the grasses in mid—October.  `,
`  Layabout gazed about, dazed. What a sudden fall! And, he realized, what a beautiful wall! Like gold it shone, embossed with suns at the corners of a cryptic riddle:  <br>\
 			WHOSOEVER BURNS TO SEEK <br>\
 			IS A DRUNKARD — WEAK, NOT MEEK! <br>\
 Perhaps it was an insult, after all. Layabout was not sure. But then he remembered his purpose in coming here, and that was that.  `,
` The existence of the Magician December surprised Persimmon.  Not because she did not believe in Magicians, although — who would have blamed her, in such a case? Few people do — but because his face was so round and jolly and smooth. He looked just like a good bread pudding, thought Persimmon, but patted dry. And this dryness brought a further element of surprise into the mix. Since her arrival in Salville, Persimmon had felt helpless to prevent a seemingly unanimous response of sweating discomfort in her presence. <br>\
 \"It's quite all right, you know,\" the Magician said consolingly. \"They don't respond well to strangers; few people do.\" Perhaps Persimmon should have been concerned by his apparent fluency in her thoughts and emotions, but she had exhausted her reserves of clever suspicions for the time being. She longed to be cajoled and coddled. <br>\
 \"Why are you so kind, then?\", she asked crossly. Part of being cajoled was letting your interlocutor know how you felt, even if the feeling was unpleasant, and generally expecting tenderness in your direction thereafter. <br>\
 \"Because I think of people as ingredients,\" the Magician December replied, and for an instant he did not look jolly at all. He looked old, clever and very wicked. All traits, Persimmon realized that she might have noted earlier. But the jolliness had smeared everything on his face like Vaseline. <br>\
 \"I'm used to the Salvillians,\" he continued, amiable as a little pig. \"But they are rarely of any use to me, you see.\" Persimmon nodded, still ill at ease, but too tired to do more than look around the office vaguely. Here a bat hung, desiccated, strangely smiling; there was a cast iron  `,
` King Layabout frowned. He was not sure what to tell the troll. Goldenrod, to his relief, rose up to her feet and snatched the scroll from Hiffet's arms, somehow without any of it ripping on their beefy expanses. <br>\
 \"Common knowledge\"…\"the Goat King\"…\"usurper of authority\"… Why, this is nothing but Sedition!\", she exclaimed. \"And I've no idea who this Goat King might be, though I am very sorry he ate the wisteria you were working so hard on,\" and here her voice dropped to a more cajoling tone. \"But he is an imposter of the most brutish sort, I do declare!\", and here Goldenrod stamped her (right) foot many times with such fervour that eventually Layabout gave her a little tap on the (left) shoulder. <br>\
 \"We must be off,\" he told Hiffet sternly. \"This writ is nonsense. Please burn it.\" Privately Layabout felt very pleased by how authoritative his voice sounded. He was sure his Thinking Cap would have approved.  `,
` A fine damp greyness enveloped the metal box on wheels and, by extension, its passengers, for having payed the three—seventy—five fare they were free to gaze out the box's windows. For the boxes on wheels of this kind, for paying women and men, afforded that small luxury. <br>\
 Pereg Rhine was afforded no such benefits. His box was not even made of metal, as it happened, and so it was in an envelope of soggy cardboard that he was being transported to the Ministry of Hope. And yet, though Pereg knew it not, he had already been extremely lucky. A large bear could easily get enraged by the sight of a large moving object entering its domain, and consequently the administration at M. Hope chose methods of delivery with great care. Lone cardboard boxes were wont to escape the notice of M. Hope's beleaguered Guard Ursa.  `,
` The mooing sound was of unclear origin, Peter determined. This verdict, overlaid upon the reality of things, immediately made him feel better. Peter was ill at ease trafficking in uncertainties, or even walking about without a specific destination in mind, tasks to reflect upon, chewing the details over and over until they were a sponge sopping up everything else open to his perception.  `,
` The demon beckoned to Sansara. She faltered. The broken spoon still lay at her feet, little raspberry gazing mournfully at her. <br>\
 \"You are tired of this life, yes?\", he inquired. His voice was kind, soothing, like that of a social worker who has been advised over the course of courses and supplementary workshops alike on how to avoid alienating their troubled targets. \"Tired of the endless feedings, tired of the lazy husband.\" His speech was a lilting, purring sort of coo. Sansara's eyelids drooped. <br>\
 Meanwhile, in the bedroom behind them, a golden sort of creature was quietly rustling about the wardrobe, the dresser drawers. It was only a \"sort of\" rather than a \"whole\" because it was clear to anybody with a nose for it that this gold thing hadn't any soul. A soul contributes greatly to the sense that something is more than just an automaton. As it happens, the gold thing was a very first—rate golem commissioned to find Sansara's ripped undergarments, of which there were more than a few. It was meant to repair and replace them in their usual haunts. The cinch was in the stitch it was to use, a cursed technique if there one ever had been.  `,
` The rooster had crowed twice, unusually for everyone involved. The weather was still pale and straggly, a brief series of showers interspersing the meandering fog of the day; it nearly made Vincent long for a healthy hurricane. But, he hurriedly thought to himself, as if the speed of the rebuttal would destroy his dangerous wish on impact, he wanted sun above all; these hurricanes always seemed to end with many people dead. <br>\
 Vincent had not been alone in the barnyard for his musings. Besides, of course, the proud cock, there was Cirulina the pig (so named after an incident involving some wax and a Frenchman) and Old Remnant, Cirulina's loyal attendant. Whether rain or shine, Remnant ensured that Cirulina had the choicest scraps to devour. He himself was a wan, tremendously slender man, and it was a mystery where the energy to attend to Cirulina came from. Vincent suspected hijinks similar to the Frenchman's were involved, but kept these distasteful suspicions to himself. It was Old Remnant, after all, who had gotten him a place on the farm. <br>\
 The rooster had crowed a great many times that day. Vincent, hungry and weary, had been about to lie down on the muddy road and cry when he heard that rooster, grew lightheaded with the conviction that farm food was near. He had not yet attained a willingness to steal directly from the fields, and in any case a farmer's wife was likely to take pity on such a handsome, if sad and dirty, young man. So he readied himself to see a farmhouse and followed the crowing.  `,
` The golden fish vanished back under the waves, leaving one last glimpse at its scales bathing in water. The girl blinked. It had been so easy. <br>\
 Her chains were gone, the rags converted to suede doublet and silken pants. She carried bow and arrows on her personage somewhere, she knew this, just as she knew she could wield them. The security of others no longer seemed a threat; rather, it was a welcome thing, this new equality, an explosion of brightly coloured opportunities. <br>\
 \"You are a clown,\" she imagined a naysayer calling out from the street corner. She smirked and in thought retorted, \"then you are my balloons.\"  `,
` Her hair was slick with glaze when they found her, as was the rest of her. Her airways had gotten coated with the stuff, that was how she stopped breathing. Such accidents happened at the factory from time to time, the foreman thought, his eyebrows slightly raised so that he looked slightly chagrined, gently philosophical. Really it was quite unfortunate that Jeanne had died, but she had been doing such a poor job lately that he'd been considering switching her to the lemonade factory. It was impossible to fire one of the hobgoblins, but to everyone's great comfort they could be spurred to greater productivity by transfer to one of the more dangerous operations. For transfer—hobgoblins were told that hard work could easily reverse a demotion, and by the time they were notified that the first change had been permanent they were in no state for anything but pale pretense at Tea.  `,
` \"Samhain,\" the stubby, bespectacled professor drawled in his feline fashion. \"Who can provide the class with further information about this pagan festival?\" <br>\
 Mercifully for everyone involved, the bell chose this moment, rang. Sabriel looked at the bronze dragon clapper as it slithered out of the dome to perch upon it until next day. Not for the first time, she wondered how the dragon bell had come to be. In a sudden burst of inspiration, she came up to Professor Redford, who had ventured over to the window adjacent to the blackboard to adjust his cravat. It was a fine cravat, with lizards that scurried in its silk as if being tickled when it was touched, but all the same Sabriel was certain that the dragon bell hadn't been Redford's work. <br>\
 \"Sir,\" she asked, cautiously, stepping out of the front row of desks and into the hallowed strip upon which Redford strode with pomp every school day, \"do you know who made the dragon bell?\" <br>\
 \"And here I was thinking someone wanted to discuss Samhain!\", the professor remarked with a wry smile. \"Yes, Miss Aure, I happened to know the spellcaster very well. This bell was left to me by my grandmother.\" <br>\
 Sabriel couldn't stop her eyebrows from rising in shock.  `,
` Shellack frowned; the spell was not going the way she had wanted it to, she was furious, it was time to mutilate a lizard or two. It really was so satisfying chopping their tails off — she was not quite so vicious that she could savage, say, a chipmunk and feel perfectly at ease once the fog of rage had passed. No, Shellack was too soft—hearted, and as a matter of fact tied into her general failure as a witch of black magics. <br>\
 \"Shellack,\" Paternoster would intone from his black throne on Confession Days, \"when you first joined our coven we for you harbored high hopes, yes, the highest of ambitions! And yet in spite of our many loving forgivenesses you continue to fail, yes you persist, most abhorrently, in these abominations—!\" And here he would shudder, so dramatically that if Shellack was in a more lighthearted mood she would reflect on the great relish Paternoster must secretly feel when witches Did Wrong. But generally she would feel despair, shame and humiliation, knowing his proclamations to be correct.  `,
` The cantor yawned unselfconsciously, loudly. Soon enough a curly—haired foreigner reacted. \"Tired?\" To which the cantor nodded, and the foreigner revealed that he, too, was fatigued. As the cantor did not pursue the conversation further, the foreigner slinked off, perhaps to catch one of the sleighs at Persborough Station. It was nearly three o'clock on a cold November afternoon. <br>\
 This trip had been a source of dread and anguish with the cantor for some time. He hated dogs, hated sleds, and despised transportation costs left uncovered by his parish. It was not fair, he felt with a sudden viciousness; he shook his head. Not long ago he had had patrons, prospects… How had he ended up a cantor, of all things? What would Lubella say if she knew?  `,
` The avatar of plenty, also known as a basket of fruit, was disappointingly full. Sorrell lowered, raised, distributed his eyes one by one on the ceiling and then placed them back on the floor. He hear the tolling of the bell he knew to be bronze, and let his face betray no recognition. <br>\
 \"You are unworthy,\" the voice intoned. \"Cease your sacrilege! Cease the to—and—fro!\" Sorrell continued to stare glumly at the floor. \"Pavimentum\" in Latin, he recalled. <br>\
 A mouse startled him away from schoolboy memories and into a jitter of movement. \"Mouse!\", he shrieked, \"mouse!\" <br>\
 \"Fool,\" the voice again. Contemptuous. \"Beware of idolatry, of your greed.\" Sorrell groaned and clutched at his knees, rocking himself to and fro on the floor.  `,
` For the most part the gondola trip down the Saigon had been uneventful. When the Drossels passed the expected red panda (for the Drossels never went anywhere they were not certain would give them their money's worth) Angelica, their eldest, stood up as much as the gondola allowed. \"The red panda!\", she alerted, pointing primly to the creature in a tree which was too far way to be anything more than the right colour. <br>\
 \"Very good, Angelica,\" her father replied absentmindedly — for his idea of his money's worth was grounded in illicit visits to a beautiful widow far from the tourists' quarter of the city; However, as he had been the one to make a great fuss over the flower trellises and exotic fauna and so forth before the vacation became a certainty, he felt obliged to invest some kernel into maintaining the pretense of a sudden new interest in Nature.  `,
` Clouds filtered the sunlight limping towards the Flinaff Towers to a squalid blue. This sort of thing was commonplace nowadays, thought Eberhardt, sighing. How was he to practice for his plein—air workshop with every last scrap of scenery tinted a melancholy blue? He missed the jungle, he realized with a pang. Eberhardt, known as Eb every once in a while, sat down in the (damp) grass. Then he released his palette, his brushes, and let the — <br>\
 A fat squirrel dared to interrupt the aging art teacher's musings! Nimbly it perched upon the point on Eberhardt's face where there could have grown a mustache (the man, in spite of his partiality for clean shaves, was resolutely hirsute) and began to dig. As we all know, skin is not meant to be dug. Eberhardt howled and attempted to tear this violent rodent off the underside of his nose!  `,
` Stuart was startled by the sudden pang of jealousy that veritably seemed to strike at his heart. He was still holding the winter suited and tightly behatted Quintillius in his arms. Semilia, having tried on this witch's hat and that, was finally ready to go to the Museum of Wizardwork with the aged and likely lascivious Senex, an instructor at the queer sort of magic school she'd taken to visiting twice a week in October. Not that she had been getting instruction there, really. The Monday—Tuesday evening sessions that she was enrolled in, three—hour—long affairs the lot of them, provided the opportunity to cast spells on a human's body (Monday) and face (Tuesday) using whatever medium one desired. The realm of necromancy, naturally, was excluded, and so were any spells that would irreversibly damage the \"model.\" The heavily recommended practice of sticking to the practice of one spell and its counterpart did help in preventing the gruesome. Not that clients were obliged to forewarn anybody at the establishment of their intended magics for the night, but the session supervisors were expert enough warlocks and mages to refuse entry to those bringing belladonna or brightly coloured toadstools. Certainly Semilia had been surprised to learn how many fatal spells required the use of pineapple. <br>\
 But Senex was not a supervisor, not required to remain alert for students attempting to smuggle pineapple into Room 202. He had shown up in the stairway, once, speaking to a short man who gave advice to students practicing with golems and squirrels in the large room at the end of the hall on Mondays. For some reason she had riposted to them then, to which comment she knew not, but it must have involved skin tone or hair colour and she had mentioned orange. Exceedingly strange how memory worked.  `,
` Torlud examined the balustrade. Iron gryphons, cleverly enough done. He would have preferred marble, but oh no, Lord Weathervane simply abhorred marble nowadays! No matter that it was expensive — if he could but have taken pride in the result — hired the finest craftsmen around — but no, marble was passé! Out of date! And Lord Weathervane, indeed the whole clan, made sure to espouse their simple motto: \"Out with the old, in with the new!\" They had, of course, over the years verified and ascertained that nothing better was floating about to replace, update it. Thus far no other proverb had come up to usurp the long—standing motto — but the Weathervanes were always ready. <br>\
 It had puzzled Torlud at first. He liked things slow, steady, logically comprehensible, naturally ensuing. First the seed, then the sprout, flowers, fruit. Not that he came from a family possessed of an orchard, in fact it was extremely cold where he came from, and this nearly at all times of the year. But ever since he had come to America to serve Lord Weathervane as butler, he had had much occasion to observe the life cycle of apples, peaches, and pears, and wonder why his lord did not from the fruit of his fortune take a cue. <br>\
 Lady Weathervane, funnily enough, was less to Torlud's liking than her husband, in spite of her routines being far more predictable. Torlud never consciously realized this, and consequently never wondered why. Partly it came down to looks: where the Lord was energetic and handsome in a dashing way, as if at any moment he could be called off to war to save the day, poor Griselda looked perpetually tired and gray. Perhaps this had something to do with her latest failure in a string of attempts to produce an heir; perhaps along with roughly two liters of blood she had resigned her will to live. But beyond the question of tangible, live heirs Lady Weathervane was of interest to no one at the estate. Her dowry had been absorbed gratefully, yet too long ago to warrant any further demonstrations of appreciation.  `,
` The jolt traversed the colonnade and reached the hobgoblin's tea. He shivered with disquiet. A fellow couldn't visit the marvels of the world in peace, could he? Rackham, for that was his name, sighed and shuffled back to his shabby hotel room. This process took a few hours thanks to multiple detours and stops to nibble, munch and crunch on local niceties. Rackham was nothing if not a gourmand. <br>\
 His wife Ayartha, 2 continents away, would have disagreed with this self—assessment. Ayartha disagreed very readily with most anything these days; with three children to take care of she not only had misplaced her carelessness, but lost her agreeableness to boot. She had never gone searching for either of them at the Lost and Found, to be sure. And yet it nagged at her, sometimes: a sense that her world had once not been so narrow, that her emotions had travelled in a lighter spectrum and that she had said \"yes\" just as often as she said \"no.\" <br>\
 But saying \"no\" was just about the only way she could, if not instantiate change (neither Rackham nor her growing boys cared much for her \"no\"s), then at least make her displeasure known. And oh, how heavy was Ayartha with the thing! She had lost her girlish figure to it — not to the pregnancies, of course. Remember — a determined woman certainly can keep her figure over he years. But displeasure is a powerful agent, the true opiate of the poor. One has but to dip into its heady well, and — no need for work; no need for change!  `,
` The clouds were roiling. Peter's bread was now broiling from the heat. He, on the other hand, being chiefly submerged in temperature—controlled water, was fine. The temperature was below —10 degrees, Peter being a walrus. <br>\
 Nobody except for Marc, an old—timer at the zoo, remembered how Peter had gotten into eating baguettes. Marc knew because he used to be the one wolfing down bread with butter right before 2pm (his lunch—shift was a bit queer on the timing). Unlike Peter, Marc would accompany the baguette with a heavy seasoning of nostalgia for his hometown of Grenoble. American baguette was subpar — this mournful thought would not infrequently assail him, and yet he could not quite get out of the habit of getting one for lunch. Until he met Céline. <br>\
 Céline was new at Doughy Delights. When he ordered the usual baguette she raised an eyebrow. \"But you are French.\" <br>\
 He had been awed — she had spoken to him, this pretty young thing with whom he had Home in common. In retrospect business had been slow that day, a small chat had been no big risk for her — and still, how he had blushed with quiet delight. <br>\
 \"Yes, and so are you, Mademoiselle.\"  `,
` Nobody had expected the storm to last quite so long. Pernel in particular considered himself a grizzled native of the tropics by the time it was done, having succeeded in munching his way through half a coconut and resolved to pour himself rainwater into the remaining receptacle at every upcoming opportunity.  <br>\
 There were many such opportunities once the trio left the shell—encrusted cavern. The storm seemed to have plucked the vegetation like a small child strewing toys this way and that. The botanist, Sabrina, sadly picked up a crumpled flower from the mud. \"Hibiscus,\" she frowned. <br>\
 Bernard, though he maintained his air of imperturbability and nonchalace, could not help but think about the disarray the inclement weather must have caused in the city below. Surely the Upper End houses would be yawning open for the plunder, their usual arrays of manservants and maids on exceptional leave to help their own families salvage possessions from flooding… It was odd, for he was not hungry, but Bernard found himself drooling…  `,
` The gem was large and carried a faint whiff of sulfur, which, without diminishing its luster, gave one an ominous feeling. What fiendish tricks had been necessary to drive this precious stone out of the bowels of the Earth and into the crown of the Queen? <br>\
 Lucretia bowed again. It was not strictly necessary to kiss the floor at her feet, but many did so; she, Lucretia, assuredly would not. Lucretia had not abandoned hearth and home, broken the bond of loyalty with wailing babe and husband, only to stoop to base sycophancy. No, her battle plan was of greater integrity. It involved snowflakes. <br>\
 \"Snowflakes?\", the Queen repeated, a slight trembling audible and unmistakeably signalling the incipient disease. She was old, old, and the Salzburg Blockade, having struck in her precocious youth, had not done her any favors; she had been old for a long time, rapidly wrinkled by heartache and disappointment. Now only Lucretia knows, but had it not been for the deprivations of the blockade the Queen would have remained a ballerina. <br>\
 She had been so painfully hungry for so long. It was clear that her bones no longer poked right, nor pointed appropriately. One of her last days at the barre in the drafty younglings' room of the Academy. Her young Highness at the door. The astonishment of little Maria — the likeness was uncanny…  `,
` It was quite unclear how the earthquakes, a great shuddering, shattering lot of them, had begun. Were the machinations of Herbert the Hatlord at fault? Was Marsepina the Marsupial to blame, she of the wicked pouch full of evil? Could one plausibly accuse the heretic Norbert, that lone voice unwilling to claim that potions could demonstrably, irrevocably, perfectly transform men into mice? (There were rumors of terrible side—effects, of men forever left with wormy pink tails and insatiable predilections for cheese.) <br>\
 Humphrey heard this all, vague accusations and hullaballoos and angry quivers reaching him from the enchanted skull he kept on his bookcase for this very purpose. He wanted such unclear, salacious news reaching him at arm's length, from a physical source unappealing enough to discourage further (and pointless) plumbings. It was important to view the rumblings of the crowd askance.  <br>\
 For it was this same crowd that Humphrey the Horrible had to treat in minute detail when some member or other precipitated out of the solution and into, say, the spiraling discomforts of venereal disease. Humphrey, a notorious lecturer, would warn his clients most vigorously against future promiscuity; invariably this monologue (with certain token appeals to his audience and caged parrots, Tallulah and Wench) would last long enough for his kettle to produce a dozen beets, fully boiled. The treatment itself took the time of soft—boiling one egg. (Humphrey, though tall, was incredibly skinny.)  `,
` It was not a welcoming climate. The young Azerbaijani were very eager to explore their environs nonetheless; a sorcerer had told them this was a land of Opportunity and plenty, a sorcerer they had paid and here they were, six in total, all youths with new hopes of attaining the esteemable status required for procuring oneself an attractive young wife. <br>\
 Fezzmet in particular was looking forward to this wife part. He, at the venerable age of twenty—four, was the oldest of the youths. However he was not the cleanest. Black mold had spread across the tiles of his rented apartment's bathroom. He had been thoroughly dreading ever speaking to his landlord again, or more accurately running into him in public after performing the subtle trick of unpaid disappearance. The mold, and he did have this justification, had been  present from the time of his arrival, in amounts large enough to be visible, not quite small enough to be trace. But a woman, Fezzmet realized, would have done something right away.  `,
` \"Are you certain of this,\" asked Miss Malone. Her manner was brusque in a way which suggested insecurity, deep emotional investment in the situation at hand. <br>\
 \"Sure as pie's pie, ma'am,\" replied McLachlan with a Cheshire cat's grin. He'd been in the business for shorter than one would have thought at first glance: leather boots well worn, tan leathery hide of a skin, expert hand with the lasso. But the skin was a late—blooming consequence of childhood in Minnesota, where protective creams against the sun were not believed in; the boots, serendipitously, his grandfather's; the ease with the lasso a holdover from childhood games with said grandfather, whose name had been Joe. He had been the Joe. <br>\
 None of this would have been of any interest to Miss Malone. Likely she wouldn't even have been concerned by McLachlan's lack of real corralling experience: unlike the fine orchestra of services required to maintain her Oriental garden in twist and bloom, this was a simple job. Wildebeasts were to be gotten rid of; that was all.  `,
` \"She'd just take the chairs anyway,\" replied Martha Magpie. Her feathers were clean for once, their sheen lustrous, but this did not halt the flow of her bitterness. For a brief time the bird had appeared to be on the mend from her ways, gathering at last shiny objects like her kin. Her nest was no longer empty. And yet she had squandered it all to gain the attention of a preening bluejay. Unfathomable. <br>\
 Bertrand Bluejay it was who answered her now. \"We've already defrosted the smoked salmon. Be nice to your sister.\" Bertrand would rather have been anywhere but there. The Magpie was so moody, so up—and—down; worst of all, so needy. When they had met he'd experienced his brief glimpses of her instability as a fascinating turbulence. Now he found her stormy waters tiresome rather than alluring. Neither of them was happy. If it wasn't for their son, the unexpected Charlie Cardinal, there was no way they would still be living in the same tree. <br>\
 But Charlie Cardinal had come indeed, in his little greenish white egg speckled with pale grey.  `,
` \"What are the limits?\", Navigardis intoned. The sky around the students was dark, would have been black were it not littered with stars. The students awaited with bated breath further remarks from their sage. But a girl in a flowery dress interrupted him. It seemed that she had quietly been sitting under a large (nearly her height) toadstool. <br>\
 \"Sir,\" she said loudly, standing up, \"I feel compelled to write songs when I reach my limits. It is an odd curse,\" she sighed, hanging her head. (In fact, it was not quite a sigh, her mouth being closed, but said mouth had turned down at the corners, and a deep intake of breath caused her nostrils to flare solemnly.) <br>\
 Navigardis' lined face, in its skepticism, grew even more stern. Curiosity swelled amongst his disciples, who wondered at the outcome of this little show. The wizard, with eerie calm, asked the intruder why her predilection for songwriting ought to be of any concern to himself and to his classroom — which, mind you, extended beyond the physical realm. Why did she not challenge herself to new limits by singing in a monsoon? Some lone titters ensued. <br>\
 The girl smiled. \"Because, sir, I suspect many of your disciples are wondering about the same things. I am the wise peer some, in times of doubt, might like to turn to. For, though young, I have travelled to the Other Realm.\" <br>\
 Gasps. Silence. Horror, then smiles in the dark room.  `,
` Cenaculum sighed. The atmosphere on the brig had been tense, rigid, vulnerable to the drop of any hat or bauble. A snowflake, of which there were many (it being winter), was passable. A bauble, of which there was a lesser but passable amount, would have been intolerable on account of its visibility. Snowflakes were all unique, but they were not often held up to the close scrutiny which revealed wonder. Baubles, however, were large. <br>\
 But Cenaculum had not been elected Christmas Pirate without cause. She'd celebrate the birth of Jesus on deck even if a few lubbers would need more than a swig of Merry—making Spirits to get going! (Or, the cheaper option, a Donkey's kick on the mangy hind…)  `,
` Sigfried chuckled and slapped Fredmond on the back with such a weight of goodwill that a lesser man would have fallen. But Fredmond had not come all the way to Anvers for a metallurgy conference; being a giant, he absorbed the blow with ease. The chandelier, however, trembled. <br>\
 All in all seven of them had gathered at The Hog's Errand: Siegried, Fredmond, Gavilard, Jodfrey, Simko, Sanat and Perfidus. Laetus had meant to accompany the latter, but — alas! — the consequences of overindulgence on a massive scale had, if not temporarily felled him, then wracked his body with sufficient aches and discomforts to inspire him to stay at home in his misery. It was a shame. His jolly presence was missed by all but Perfidus. <br>\
 Nothing had gone right for Perfidus. He had failed to stab Laetus at the planned moment during the overstuffed feast (the retrieval of the mammoth turkey). All the preparations — the expense of the splendid, gigantic spread — all gone to waste! In spite of lingering concerns about the impact of tears on his dastardly image, Perfidus allowed a fat one to escape down his left cheek and streak his chin.  `,
` Jalhedro scowled, the carpet not being quite the right tint. \"Fools the lot of you!\" By the end of this pronouncement his hand was on his brow, in fact the fingers were anxiously meddling with the hairs, the nails' squeezes subtly encouraging an exit from the flesh. \"Leave this room!\", shouted Jalhedro, bolting upright in his rage. The carpet merchant and his retinue hastily performed the appropriate parting genuflections and departed, but the fifth silk—measurer did not pass through the triumphal—arches with enough haste to avoid a blow from a radiantly thrown royal scepter. (Jalhedro really was radiant with fury, in a way his underlings hoped and prayed he might some day become simply from joy. The royal scepter, meanwhile, was one of dozens the Royal Treasurer, nothing if not a practical man, had considered his ruler's temper and hurling power in devising the scepter rota.)  `,
` The Pink Fairy frowned, although the fishbowl was delightful. \"And what purpose does this fishbowl serve?\" <br>\
 \"Is it not amusing to you? Are you not charmed by the way the sunlight dapples the scales of Mix and Flix, or the horns of one, or the wings of the other?\" Just then the water had subsided to more of a vapor around Flix, now a miniature parrot. \"Stern!\", he cawed before relapsing into a goggling goldfish. The Pink Fairy felt disturbed. <br>\
 Shaking her head slightly, she forged on. \"This is mere distraction! There is nothing healthful in it for a young mind,\" she  `,
` The sun having set, the Helipota folded its wings over its abdomen. Now was its time for some well—deserved rest from the Forbidden City. Well—deserved, for it had just won the Helidoptan nation a commendation for its bravery in battle; far from the Forbidden City, for too near that sacred place everything was too much brought under scrutiny for one's true feelings on any matter to be ascertained. And the Helipota wished for something to be ascertained. <br>\
 It had been under the Helidoptean Queen's thumb for too long. Gone were its convictions, confidences, certainties. It required a break, a pause.  `,
` Tuktan presented an unknown challenge to Peter. He smiled with some satisfaction. It had not been easy, squeezing the information out of the girl… and eyeballs in particular were so messy on the way out, one really didn't expect it… But that was in the past now. He knew about Tuktan; would come, would conquer. <br>\
 A little bell rang above his head, followed by three others in quick succession. Peter frowned. He had not yet gotten the hang of these notes. His alchemical advisor had suggested to him this trick of bell installation as key to an incidental music education, but it seemed to Peter increasingly, with each passing day, that he could only get a music education by brute force. Now Tuktan, on the other hand, might require a finer approach, subtle tactics. <br>\
 But the chief purpose of the bells was to alert Peter to whatever might be advancing, whether loyal soldier, rival chieftain, or peacock. (There was a special tripwire system for fowl, one which rang a little bell with a birdwhistle of a voice.)  `,
` Nobody could agree on where to put the conspicuous jewelled egg carton. In the pine tree? Too much at the mercy of the elements. In Sidka's safe? Thieves were too ingenious nowadays; on this everybody agreed. Under Clément's hat? (He never took it off, after all, and it was large enough to stash a whole dozen cartons in!) Perhaps… <br>\
 The trouble was, nobody could agree on the True purpose of the precious carton so recently thrust upon them. It had been the present to Trolbrig from his Aunt Jein, yes. Had he wanted it? been skilled at duplicated gold fishes? Trolbrig was no deft hand at riches, you could see that simply from the way he ate. Why waste caviar on a man who wolfed down any pancake… \"Give the carton to me instead\" could have honestly come from twenty different girls in the class, Sidka excluded.  `,
` \"Well, that one came right on time,\" the turtle said amiably to the hare. Its furry companion was pacing from foot to long foot, trembling almost with something the turtle could not name. But you and I know, or at least I can tell you, that it was a mixture of guilt and lust.  <br>\
 Now, I don’t mean lust for adventures in which participants are at least partially naked. I am referring to what is unnecessarily long—windedly referred to as Lust for Life. The thirst for adventures, novelty. Very many people neglect this natural feeling utterly, which is why very many people are so sad. <br>\
 Let me expound further. Lust is tied to vocation. Not all of one's life energy can be directly poured into making a family; moreover, it is extremely easy to make a family with the wrong partner. I am of the opinion that so many Greek myths involve young virgin princesses or nymphs being Taken by Gods in disguise precisely because the instinct to reproduce can Take one, and especially one of the female gender, so much by surprise. Moreover, the drive can appear impossible to repudiate; it is profound, animal (hence even Pasiphae and her bull.) <br>\
 But, alas, the truth is, such dramatic raptures end not well. I have seen many tragic cases, heard many mothers bemoaning their fates. And so I urge every young woman reading this, and every relative of a young woman I urge the latter to warn, to be patient, measured; to work upon oneself and one's accomplishment, to clean whatever muck lies in your stables before you let thyself be overcome by misplaced lust. <br>\
 Truly, I wish to start a petition! May what is currently known as \"lust\" be relegated to \"wantonness\". For it is a criminal waste when people's Lust is automatically taken at face value, in situations of Wantonness. Lust is like to be misdirected when there is no safe, appropriate avenue for it. And yet — life is long! <br>\
 Surely, if you are young and lusty, you had better travel and see what seems good to you. If you have been shy and secluded, it is your time to be brave. And now, let me interrupt with some musings on Helena from \"All's Well That Ends Well.\" <br>\
 She is the heroine of a Problem Play of Shakespeare's. Her father is dead. How long has he been dead for when the play begins? I think, in my overidentification, of my own father, who is alive but from my life so painfully absent. I wish to speak of my Songs and of my Self. <br>\
 One man, in the last century or so, had the temerity to write \"Song of Myself.\" Alas, I forget his name. But  `,
` Portlitus gave a little snort and jumped up, clicking his heels at peak height. At this sight the penguins could not help but giggle, too. Only Sedinus continued to frown. <br>\
 \"Just think,\" Portlitus announced giddily, \"I'll be rich! Famous! We can have a house in any which duck lane you want!\" (The penguins had long expressed their admiration for lanes full of ducks, initially to the surprise of Portlitus who had been sure they would rather neighbour other penguins, or even seals). He adjusted his gleaming lacquer bowtie, clearly full of nervous energy. Perhaps he was a tad bit shy about the elated jump. \"And Sedinus,\" he continued, somewhat more warily, \"you'll be proud of me then, won't you?\" Portlitus' face was painfully eager. <br>\
 Sedinus heaved a sigh, rolled his eyes for good measure. His locks were perfectly tousled, as was his wont and custom; even the adoption of the penguins, the huge upheaval caused by the presence of nine waddlers had not forcibly trimmed this fat from the haunch of his schedule. Arguably it was not mere fat: who was Sedinus if not attractive and set in his ways? Only once had Portlitus seen him with a hair out of place. <br>\
 \"I've seen the Six Persimmons,\" Sedinus commented, playing with his second—to—the—left forelock. \"There could have been eight and it wouldn't have made a difference. Two, even.\" For a second it seemed he would tug the lock too tightly, perhaps even pull out a hair. Just as suddenly, he let go and stood up. \"Why are we having this conversation again? Before we adopted the penguins you told me it was over with the Persimmons. Now each time we have  a drink together you start talking fruit and glory!\" The mention of drink galvanized him to a next sip of cider. His tone became more gentle. \"I know you're confused. The first year is always hard.\" Approaching Portlitus, he gave him a pat on the back. \"Do you want a hug and a kiss?\"  `,
` Vittorina's heart. She was dead. Suddenly she was aware of a great feeling of lightness. It was very calm, very quiet, and in front of her cherry trees were in bloom. Is Heaven like Washington, D.C.?, she wondered, never having been to China. <br>\
 \"You have been cowardly,\" came a voice from Vittorina's left. She turned her head, saw nothing on the stone balustrade; swivelled farther back. The speaker was a soft white cat, still slender with youth by appearance, eyes odd and red. Vittorina shuddered. Those eyes were off. <br>\
 \"You never spoke your mind, nearly,\" the cat continued laconically. \"Fancied yourself better than all those people along the way, but never told a soul — save that fool husband of yours —, nor made anything of it.\" This was all too apt. Although Vittorina was growing apprehensive about her chances of going to Heaven, she could not help but nod in agreement.  `,
` \"This weight is as heavy as a full—grown bull,\" the red—lipped saleslady announced gaily. For some unknown reason a veritable crowd of four moneyed individuals was listening to her spiel, only half of which were not women. The moon was up and glowing, and this far from the city the sky was modestly littered with stars. But here were George, Ewa, Brend and Loïc quietly expecting more from their Muse. (For they were all students of Art.)  `,
` It was an unsettling feeling that slithered into Toonag's chest just then, off the left side. Its delicacy helped it somehow, dulled the discomfort that would otherwise certainly have induced Toonag to scream and call the cops, citing poison (911 being easier to recollect than the Poison Control Center's number.) <br>\
 It was strange how interchangeable the days had been prior. A palm tree there; a sudden irruption of seashell on the sand, a coconut shell vendor who had fizzy drinks in cart and very soon in hand. Fluorescent bracelets, blocky, ugly things authorizing license for vice, licentiousness and milder, humbler overindulgence. Ploughhorses kicking back their heels, usually for less than a week, all transportation time excluded. Some people came back boiled red like lobsters, pounds heavier from day—long drinking (Cuba was notorious for its fare, which though fine in the simple things was no Mexico, certainly no Mexico like the North Americans craved.)  Some travellers, sole travellers, returned looking dark and mysterious with churches and nightclubs. Those with children or over seventy years of living tended to be the rare prudent. <br>\
 But Toonag had forgotten all that so quickly. The face, familiar, beseeching, had sidetracked her as she stood on the main balcony admiring a chameleon.  `,
` \"The party, the party!\", Linda squealed. Her yellow dress rustled as she moved about, chiffon roses making their presence known. Linda was very excited indeed about the party at her momma's friend Olga's, and it was largely because parties were the time to put dresses on. Moreover she couldn't wait for her friend Michelle, Olga's eldest child, to see this beauty, the roses… She sat down and sighed happily. <br>\
 Linda's mother was a dentist, her father a surgeon. Linda had grown up with a perfect smile as well as the smiling reassurance that she, at least, would not have to spend money on Botox (\"Bow—tox?\", Linda had asked, blissfully innocent of the existence of a large market for preventing wrinkles.) <br>\
 But change was coming into Linda's life anyway. The party at Olga's was about to dissolve…  `,
` The mist was sinister, enveloping the little park in that fashion, Tina thought. The rain, on the other hand, was an innocent passerby, troublesome only in its refusal to partake in milk and gingerbread cookies. For the month of December was getting on, and in spite of the day's relative warmth, the bare wet trees debauched of their heavy snow merely made one long for True Winter. And either way everybody with the time was getting a head start on holiday goods. <br>\
 But not Peter. He scoped the park out with a quiet fury. Where was Glengarra with the promised acorn jewel? He tapped his left foot, sloshing around a shallow puddle, the satisfying smacking setting free some of his rage — but only some. For recently, generally, he had been brimming with rage. He was in constant danger of sputtering it out like droplets of soup.  `,
` Solemnly the priest poured the mango nectar down the boy's forehead. Every gesture was carefully considered, so as to incur the gods' approval rather than contempt. Yuri had been waiting for this moment. And yet — and yet. <br>\
 How he had pleaded with his pagan wife for the protection of their son's soul to be solemnized! How many times he had brought up the cause. But time, time was ticking for him too, at last: the fine webs of wrinkles would soon extend beyond the sole crease, his blood congeal… It had congealed already. Where once he had sung, he changed diapers. He had been able to say no to his wife, once, too, had the opportunity to slink off and away. Never mind that he had oft proclaimed himself miserable then. The worst misery was the misery of two. He shuddered at the thought of what would happen when they were three, for the boy did not quite count yet. (He hoped not — already too much screaming heard already otherwise.)  `,
` The snow was falling thick and fast, very much like myself with amorous sighs and declarations when a pretty sparrow has caught my eye. Allow me to introduce myself — I'm Perry the frog. <br>\
 Why the sparrows for an amphibian?, you may wonder. Surely toads would be more suitable candidates for an amphibian's declarations? And  `,
` The wizard surveyed his aquarelles; then the canvas, then the full moon out the window. He reflected, stroking his beard. How good it was at times, this elderly male guise! The independence and solitude it provided were resounding, as intoxicating in their own way as the brew shared by Tristane and Isolde from a jewelled cup. For what was that sort of love if not an illusion — the moment of seeing all one was beginning to lose in oneself, or to disavow, in another, the recognition generating a pull like that of a planet to a moon… The wizard shook his head and went back to considering his blues. <br>\
 His last painting, in blues of oil, had been too harsh on the midtones. He needed to go softer  this time… Memories of Clarissa the three—eyed cat surged into his mind. How he had enjoyed petting her deliciously long fur, hearing her purr… He had been very disappointed indeed when the Oracle told him the liver of a three—eyed cat was the best ingredient to bind oils to gold. The chalice, to be sure, had turned out beautifully. <br>\
 During this time of reflection the wizard's hands had not been idle. He was surprised to find a large French braid in his beard. He remembered Thaïs, who was now probably still a tree. What sweet little rat—tail braids she had made! <br>\
 It was better like this, with the catalogs of recollection. He was at peace… and yet it was hard to work without an audience, a target. Was this so very wicked of him? In his former guise he had ceaselessly lamented the intrusiveness, inquisitiveness of people… He shook his head. It did a wizard no good to be hungry. Time to summon a sugar—plum sandwich. <br>\
 The gingerbread slabs appeared first, stolen from one of the Lesser Realms judging by the speed. Next came the whipping cream layer, with a delicate infusion of almond extract (the latter of which, he knew, because of a long—ago trade agreement with his stubby elf friend Tina, the exact source: a cast—iron jar engraved with almond trees and salamanders.) And then, unusually soft, the sugar—plums.  `,
` The flasks were never empty; the liquid, sometimes amber, sometimes purple. When it was amber the women knew the men would be loud and on the prowl, whether taken or not. When it was purple, Izaïda knew to expect many complaints from young, inexperienced women on the morrow. The purple liquid was vital to the men's sense of the world, of power; helped them to reach the mindset of the jaguar. But perhaps it was essential for these sad, battered women too. Not everybody can be the jaguar. Squirrels are lucky when they survive. <br>\
 Izaïda  `,
` The clown was nearly blue in the face, though that this was apparent did no credit to his Hoppelmaker face paint. \"Let me be,\" he choked out. Dog—man loosened his grasp on the wretched entertainer's neck, let go (a loud series of bumps and clangs ensues as the body made its way down the pipes) and scratched his left ear thoughtfully. How silly the clown—man had been! His nature forced him to obey every command… moreover, he'd been set to release his captive in a few more minutes. Now, as it were, a life had gone down the tubes for nothing satisfying. The Dog—man would get no reward for this. <br>\
 He had not always been so obedient, well—concealed as this present trait had been. As it turned out, one simply could not become part Dog without forsaking some individuality. The master, or even casual bystander, could direct his body, divest him of the power to enact his will. It was pitiful. Why had he chosen to become like this….? Surely not for the nose, nor the tail… <br>\
 The relief — that was it. All had at first seemed much simpler. His meals were provided now, his walks regular, his master known and confirmed. Being a dog, by no humans was he spurned.  `,
` Sayonara pulled the rope above her head. A tinny, cheap—sounding sort of bell rang now. Sayonara wondered if the sound was pre—recorded — no, no time to waste on such thoughts. She smiled at the crowd in front of her. She must embody Gratitude.  <br>\
 It had been oddly summer at the top of the Barren. She shuddered to think about the places the Fame, the menial drudgery of the days.  `,
` Morning had come and gone, its memory mere smears of chalk on the sidewalk after a rain. The Stranger rubbed his eyes, dug the dry little pebbles out of the corners, near the gummy pink bits that looked like the vestige of what, in chickens, was called the nictitating membrane. It was cold, too cold for coffee. He needed some Dragon's Brew tonight. <br>\
 This beverage he kept always on his person in the winter, though he rarely used it.  But it was important to him that he know it was there, you see? In the nice solid silver flask he had won in a land of Araby, Iran was it, for a perfectly prepared persimmon tea. <br>\
 The caution the Stranger displayed with his Dragon's Brew was partly due to family circumstances. His mother had told him of her shock and shame, in childhood, at seeing her father out sprawled. Simple alcohol the reason, really. Yet the propensity to excess, to swings of the pendulum, he seemed to see in all his blood relatives to some extent, and he knew just how dangerous this tendency had proved in himself…  `,
` The fires blazed all around the city. Piyong—yang the clown was powerless in the face of so much smoke, and especially so many wailing women. He stood up from his beparasolled table and walked away. Once he was far away enough from the café he switched his brisk trot for a run. <br>\
 It was inexcusable that he should forsake his Emperor in his hour of need, and yet what else could he do? He had forsaken him for the first time many years ago, over that small matter of the hot—water balloon incident… Piyong—yang, even mid—run, could not help shaking his head at that recollection. <br>\
 So many paths he had taken since their initial parting, ever coming back with his tail tucked between his legs… Recently he had proclaimed fervour for Pirulina of Comatche, greatest and most splendiferous of the ruby—red—lipped clown females… And yet, in spite of his protestations of devotion, in spite of his multiple deliveries to her of items rare and prized as the Jack—in—the—Box made of wicker and leaves, he knew his life to be hollow and his heart to be devoid of love. <br>\
 He never could bring himself to understand it. Into the vase of his life joys came and seeped out again, through a difficult—to—locate crack. His time with the Emperor had habituated him to grandeur, ceremony, servility, true; had taught him to sneer at those of other countries, other lots, essentially everyone who was neither the Emperor, nor himself.  <br>\
 But the Emperor was growing old, and he was no longer young. Were his former master to perish in the fire, what would he do…?  `,
` \"Nobody would ever draw someone as ugly as you,\" the Toucan snarled. Sorry, the Bulldog — funny how one can confuse such dissimilar animals for one another. But it was a very hot September. I digress.<br>\
 So the Bulldog had snarled at Kate, the little Chimpanzee. Kate, being a chimpanzee, remained imperturbable. That is to say, she smiled a little and continued to pick at herself for fleas.<br>\
 Outside the Pound was a veritable array of shady individuals. Tina, an astonishingly mangy Doberman, was trying to coax a sugarette from Harry the Horse, well—known dessert fiend; Romy the Racoon was giving his little sister Bertie the low—down on rates for a tail dance by neighborhood (grey squirrels were likelier to be stingy than black ones, Bertie had understood thus far). Rick the old Tabby was gnawing away still at the mysterious corpse by the dumpster, with a wide berth his sole companion; while opinion was mixed as to whether the remains were his mother's or his other old lady's, nobody could argue that the skull had been a feline's, and that Rick was no innocent. `,
` ''The experience was positively dreadful, Lady Bishaw,'' announced the latest addition to tea—time, a pretty young American with the marriage prospects of a particularly tasty piece of cheese. Though poverty had not been kind to Miss Kent, or rather, had gotten its grubby marks all over her, Lady Bishaw had determined to make of the American girl her pet as soon as she saw her attempting to sniff roses from The Gardens. It had been the sort of faux pas a native of the parts would never even consider, barricaded by knowledge of the synthetic advancement `,
` \"Regards, Your Mother.\"<br>\
 Reginald blanched and rapidly concealed the message under his collar. How like her to haunt him thus! Alas, she had struck a nerve — and this when he had reached the very eve of his great attempt, his final trial, of the Doomsday Device!<br>\
 For those in the know, Reginald was on the tip of destroying the planet. Indeed, his fellow Scientist admired him dreadfully. To his family, however, Reginald had been good old Reggie ever since he had reached the age at which one might commence playing cricket. Nary an accomplishment of his would induce them to think differently of him, or forget that he had once squirmed with fright at the sight of a falcon. `,
` Once upon a time there was a girl who did not know how to put her foot down. She had been walking on air for too long, you see, and it is hard to get used to the workings of gravity. <br>\
 Perhaps it is relevant to note that she lived under a thundercloud. It was the family pet; its name was Ivan Ivanovitch. Ivan Ivanovitch, although a cloud of a stormy disposition, looked very kindly when he was not frowning. Such was the benefit of twinkling blue eyes and a bulbous nose.<br>\
 On one mild February day the girl wondered whether it might not be time indeed to put her foot down at last. She peered cautiously down onto the carpet of the library in which Ivan Ivanovitch was blocking the sight of the roof. Dirty as it likely was, with the germs of hundreds of booted feet, the girl wondered how it would feel on the soles of her feet. She stepped down.<br>\
 Boom! went the lightning flash! Was it the end of the world? the girl could see nothing; all was blinding white. Then, gradually, all became smoke, and dissipated. Unfortunately everybody else who had been at the library on that mild February day was charred black. Steam hissed off them as the rain began, and the drops hitting the corpses reached boil. `,
` \"The guilt can eat one alive, you know,\" the Fairy remarked pensively as she bit into a biscuit shaped like a toe. \"Good luck,\" she added, in a gentler tone, before fading away in a puff of smoke.<br>\
 Cindy looked at the box the Fairy had left behind with surprise. It was exceedingly large, to begin with; it had definitely not been there  `,
` The sky was darkening and the dirty, crusty patch of unmelted snow under the tree Melbourne knew not how to name was swiftly turning into less of a menace to his serenity. Given how little Melbourne was sleeping nowadays, virtually everything had become a menace to his serenity: everything and everybody around. This was not the kind of thing Melbourne could admit, of course; he preferred to overeat or to drink wine.<br>\
 As Melbourne continued walking along the Bast—a—Liais' road his thoughts swirled in little eddies, his fingers coruscated and soon enough he was nothing at all again. The day had grown very bright, consciousness was coming back somewhere, in fact he could remember that he was Eddie Marchbanks, a three—year—old child. He knew that he was three because yesterday had been his birthday, and he had been very sad to learn that his parents did not intend to give him any elephant at all. There was a cake, with three candles, but as it had neither four legs nor a trunk it was completely irrelevant. Although Eddy generally enjoyed sweet treats, all he had been able to do in the face of this cake was cry. And, thinking of it now, again he began to cry. To his horror, after he tried to rub his eyes dry, he found his eyelids would open no longer, and the whole of his face felt disturbingly soft. In fact the skull was caving in, and Eddie was disappearing; the light of life dimmed as the puddle of a creature shrank to an amoeba. Before this final stage the mess shrieked \"help!\" through its tiny mouth. `,
` It was an honorable chair, on that note everybody agreed.<br>\
 Perhaps the price Ms. Eldercroft had paid had been too high for it. Her famed porcelain skin had never seen the light of day, or at least was not espied by gossiping tongues, after her marriage to the Baronet Twimby. And the chair upon which the crowd was gazing at that moment, of course, having been part of Twimby's bridal gift, was only now grown available for public purview. Death tended to raise curtains in this manner, and neither Eldercroft nor Twimby had been in good enough form to resist the Gold Ravage of '84. <br>\
 To be sure, in '84 everybody had been thinking of nuts, chocolate, ice cream. Brisket, during the week the grocery store had preened under its fine prices for giant hunks of meat. `,
` The boot Maurice was in search of failed to materialize within the first sidewalk square. An inauspicious start, thought Maurice, before bravely forging on. The air was fragrant with orange trees, which lessened the sting somewhat. Maurice had abandoned everybody he'd ever known and loved for these orange trees.<br>\
 The boot did not turn up over the next five blocks, which almost thoroughly discouraged Maurice from further investigation. Rarely did Maurice venture two blocks beyond the raspberry—shaped building he called home, let alone five. Every excuse in the world was suitable for this limited perimeter of life — toothache, ill omens related to birds, indigestion. And yet here he was, the total of blocks traversed now numbering six!<br>\
 This Herculean effort on Maurice's part was not to go unnoticed by the world at large much longer. Soon enough a gnome peered out of his red car as he whizzed by. He is admiring me, thought Maurice as his eyes met the gnome's. He sees and understands the pains to which I am going on behalf of my beloved Neptune, Maurice decided, and nearly choked up with emotion. Then the gnome's little vehicle moved on, and Maurice remembered how to swallow properly. (He had been eating grapes at this stage of his odyssey, for sustenance. In case he reached eight blocks he had packed a lamb leg.)<br>\
 Should you be wondering where Neptune was at the time, allow me to paint the scene. A beautiful young lady wearing as much calfskin as possible lounges on a velvety sofa, one foot — the right — conspicuously bare. Round her neck lies a chain from which dangle the letters of LOVESTRUCK, but in the wrong order. STROKEVULC. `,
` ''That is over,'' the Marquess said coldly. His smile reappeared, as spiteful as ever. ''The Golems will escort you out.''<br>\
 Philomel was in a state of shock. He felt as though he had been spatchcocked; wished it had been so, almost, so intolerable did the pain feel. Once he had been but a simple mountain boy… Now, alas, he dreamed of kings.<br>\
 The Golems were, as is customary, made of clay; but these seemed part of an especially shoddy batch of creation. Even their names — those secret inscriptions upon the papers they held within their mouths — were oddly visible. Any experienced warlock could have read these henchmen's true nature and disposed of them in one rapid mish—mash. `,
` Pilss was born with a full head of lollipops, which I wouldn't recommend to anyone. Certainly this little surprise caused untold levels of pain to his mother, Klara, during the delivery of little Pils unto the world. For, you see, it was a natural birth, so not only a baby's head crowned from Klara's vagina but also an array of mighty prodding lollipop sticks.<br>\
 Over the years the lollipops came in handy to Pilss. She bribed friends, wooed enemies, and murdered squirrels1 with these sticky treats [1 Squirrels, might I add, that had been terrorizing the expanse strewn with tulip bulbs in her mother's front lawn.] In the darkest times, she would have one herself, for comfort. It is quite special to know that you wield the same power to soothe as the mother of a suckling babe does with her breastmilk.<br>\
 But one year, alas, the lollipops began to break. <br>\
 Pilss had discerned subtle sounds of cracking throughout the schoolday; she had assumed they were coming from the ceiling. Considering the age of the University of Heffgen, this was not out of the question. Indeed, as Professor Vassmirk lectured about psychosomatic mitosis Pilss wrestled mightily with herself as to whether to interrupt the class to ask about the ceiling. `,
` Bruno's face had been vastly compromised by the Manticore's clawing. Not only was his beauty in tatters, its integrity was gone: blood spurted from various crevasses to which streamers of useless skin were sadly adjacent. While the Manticore seemed pleased with its work, it was hard — due to the abundance of mangled flesh and such — to tell how Bruno felt about it all. As a matter of fact, Reader, why don't you tell me? Pull out a coin! Heads he was glad, tails it sucked.<br>\
 Anyway. The Manticore was making move to head off, Bruno's mighty Sword clutched tightly in its tail, when a woozing sound lurched  towards said tail. The sound was accompanied by a shape which had sprayed mists of red in its movement. <br>\
 \"Bruno?\", the Manticore asked worriedly. This hadn't been supposed to happen. Typically its maimed victims skulked off as soon as possible, reappearing perhaps within a year or two in their previous social circle. But these returns were merely perfunctory. The Manticore's loving touches could only be masked so far, and as the targets knew they could only feel self—conscious about the extent of their scarring, so were their old friends unwilling to absorb the extent of their woes. We all have problems, do we not. `,
` Having imbibed a full thimble of Madam Hoochis' finest beverage, Rostina burped and giggled. Nothing too sensible could be expected from her now, save perhaps an awareness that she had yet to complete her tax returns. The moon was bright, she noted, and as round and full as a dinner—plate. At the thought of dinner, Rostina looked searchingly to the stars. Her thimbleful had not been accompanied by anything of more substance. Madam Hoochis had, after all, promoted her Dirt Cheap Thimble Friday Special with the reasonable assumption that customers would at least order fries as a side. Or something else made of potatoes `,
` Once upon a time there was an aging beauty who no longer had lips, not really. Injections were the likely culprit `,
` \"King Stephen has ordered your immediate removal from the palace, Sir,\" Fenwick sternly told the Snail. The Snail, in a remarkable display of sang—froid, merely quivered his snout until his monocle fell over. There was the slightest hint of a tinkle, the glass having been exceedingly thin. Snails did not require more than costuming from optometrists.<br>\
 Fenwick was taken aback when the Snail  remained still amidst tiny shards of broken glass. He had naively expected the mollusk to skulk away in embarrassment after his announcement. Anything but this stillness should have followed the subdued declaration of war between Snail and Man. `,
` \"The dragon tenderloin must be brought to room temperature,\" sniffed the great chef Apuleis. Back in the day Apuleis had been not only a chef but an expert hunter; as a matter of fact, the hunting had preceded his expertise in the kitchen. But what is a man to do when his wife dies, and the desire for gourmet meals remains? Killing bison is of no use if it merely leads to overcooked steak. And dragon—hunting in particular Apuleis did not desire to consider time wasted. He should hope, thought he, that risking being burned alive merited the soothing outcome of a delightful meal. And Faselina, bless her soul, had accompanied the dragon steaks with such fine bread loaves, perfectly tender asparagus stalks; fried mushrooms sliced so thinly that their texture, for once, could not remind him of slugs.<br>\
 Boltuss, Apuleis' apprentice, knew nothing of Faselina, in spite of walking past her portraits every day. There was one in the entrance, of her bearing elderberries in her outstretched hand — commissioned not long after their engagement, Apuleis recalled — ; one in the kitchen, wherein a stouter and ruddier Faselina glanced out inveiglingly at the viewer, with the additional enticement of bearing a cornucopia upon her head. On the hallway of the lower floor was the sad one, in which a masked Faselina frowned. `,
` \"The radish!\", Semolina shrieked. \"Bring me the radish!\"<br>\
 Bluebird swivelled about jerkily and near—hopped with trepidation. To his great concern there were bell peppers, cucumbers, Nappa cabbages, rutabagas… but nary a red sphere in sight. Flustered, Bluebird wondered whether now would be a good time to burrow underground. It seemed like there was quality dirt here, moist and rich as German chocolate cake.<br>\
 Semolina had noted Bluebird's hesitation without a hint of pleasure. She was starting to run behind today's schedule — there could be no regrets now, no apologies, only actions. Bluebird, unfortunately, was not a worthy hire; he panicked under such circumstances. However, Fortune had smiled upon him: Semolina was willing to keep him on until the end of Onion Season. For Semolina, you see, was willing to take risks when the strength of her good will was in question. If she could reform Bluebird, she could do anything!<br>\
 \"Bluebird,\" she said, hastily, \"no radish, quite right, run to the Unedited.\" And Bluebird gasped.<br>\
 Nobody went to the Unedited Parts. It was much too dangerous — never mind that it was possibly illegal. `,
` Devilish stirrings were a—cloven—foot in Siriebel's heart. She had learned of cream cheese icing growing in a nearby Tree… begun to consider stratagems to make use of such icing—blooms — say, through new commerce in carrot—cakes: never mind her current notions of completing the family Grimoire or, mayhaps, some blessèd day terminating her and Evan's cleaning of the Nook.<br>\
 The Nook, let it be noted, had never attracted much interest from the party of Spiders which frolicked so in Siriebel and Evan's hometown. Nevertheless, Cobwebs are not the only follower of that wretched knave Domestic Neglect. Dust and crumbs choked off access to the Nook's floor, so jealous were they of its contact with the Sun's light. Grease—stains marked Evan's apothecary—desk, bones littered his lady's supposed alchemical table. `,
` ''There is nothing for it,'' muttered old Glennitch to Tall Sally (who was firmly past his seventies, but nevertheless remarkably like to a Roman column in stature). ''I'll have to go to Scotland,'' Visibly defeated, he fumbled for the quarter on the table and started — to a small degree, of course — tossing it about.<br>\
 Tall Sally's eyes flickered to him with amusement before flickering back to the ornate book in his hands. Palms, really. It's worth reminding you of Tall Sally's height again at this point. There were sordid rumours that his mother had copulated with the Giant. <br>\
 For what it's worth, although nowadays the young are quick to dismiss the Giant as but one of many beards of myth, I believe that where there's smoke there's fire, and a hell of a lot of fire only can choke like rumours of the Giant do. I've heard about him from disgruntled innkeepers, bellhops, prawn—catchers, lawn—cutters, lamb—trimmers — even the fair, young and rich! This guy's huge fingers have been in every pie — to our great cultural benefit, I dare say. Nobody's inspired either teachers to as much invective or publishers to as much bank. Also, I'm pretty sure I saw him out my washroom window once, when I was taking a bath. (I live in a pretty seedy part of town, by the special bar named after the last queen of Egypt. You know the one. Lots of people seem to have nieces to visit there, and they always blush when they say they'll do it.)<br>\
 Anyway. So Tall Sally was back to that fancy book of his, and Glennitch was complaining to the high heavens. \"I hate Nick! Why on Earth does he want to join me on this trip?\"<br>\
 Tall Sally merely raised an eyebrow this time, nonchalantly flipping to page 157 of _The Mightily True Memoirs of Me, Jean—Paul Robitaille, A Valuable Soul_ before idly pointing out that Glennitch was perfectly capable of politely declining Nick's trip—buddy advances.<br>\
 \"But, Sally,\" stammered Glennitch, \"the bastard's my cousin!\"<br>\
 \"That's another matter,\" Tall Sally replied after a couple of scratches on his long nose. \"I guess you'll have to kill him.\"<br>\
 This suggestion perked Glennitch up remarkably. \"D'you know, Sal, I think you've hit the nail on the head you did!\" Eagerly he reached out for his stein, which turned out to be empty, before gesturing to the bartender. \"Lady,\" he exclaimed, \"I'd like to toast some Tennent's Lager in honour of my cousin Nick!\" `,
` Once upon a time there was a girl who was really keen on shortcuts. Well, between us two, she was much more of a woman, but you know how sensitive some people get about these things. <br>\
 Anyway. The girl I'm speaking of was so terribly intent on shortcuts that, one day, she made the shortest cut of all.<br>\
 When she came to the light was blinding. `,
` There was a rustling in the tall grass. Gemino cocked an eyebrow. Out of the green front burst a viral Calendula, green vines choking its beautiful visage of petals. It wailed piteously before noticing Gemino. When it realized it was being observed, it cleared its face of expression and solemnly bowed, vines dangling as its head went forwards.<br>\
 Gemino knew what was next. The thought made his stomach clench. Suddenly he remembered his dear friend Petunia, whom he had so cherished. Lost to those vipers! Unexpected rage filled his belly, made him strong again. He put his fingers on the talisman at his neck.<br>\
 A ray of green light shot out at the diseased Flower—creature, withering the creeper spiraling upwards from his nape. The Calendula swooned, its delicate constitution overcome by the brightness and sudden freedom. Gemino, ever the gentleman, caught the plant by her (for Flowers generally identify as female) back. This unexpected contact did even less to bring the Calendula back to her spirits, as she was painfully shy and a virgin.* She fainted.<br>\
 [*That is to say, she had not yet been pollinated] `,
` May I tell you a story about a little green man named Bob. His hair was very long, trailing behind him like a veil made of lawn, and passing ladies would giggle, therefore, at him when he walked. ''When will you grow lilies,'' squawked they, ''Bob?''<br>\
 Bob would not answer. He was too busy dreaming of a day when he'd turn yellow as his favorite meal, corn on the cob. Bob spent an awful lot of time thinking of corn on the cob. `,
` The rabbit, fuzzy, charming, and miraculously white, in spite of its penchant for leaping into bushes, looked remarkably confused. I say ''remarkably'' with pointed intention: it could have been ordinarily confused, and merely shrugged its shoulders, or wrinkled its little nose. (Which, unlike its fur, had gotten scuffed or daubed in its rituals, changing from pink to blue.) But this fuzzy, adorable creature was so confused that its long ears were as upright as antennae, its pupils were dilated, and its blue nose quivered with the news. It nodded at the sailor and hopped off to share the news.<br>\
 ''Bluenose is coming!'', whispered the squirrels.<br>\
 ''Bluenose is coming!'', chirped the birds. <br>\
 ''Is that Bluenose?'', a fox pup asked her mamma, who had been trying to rid her of a tenacious wood louse. ''I do so wish we could eat that rabbit, Mamma. I'm awfully hungry.''<br>\
 Mamma, who always became dreadfully irritable upon realizing that her family was plagued with tick or louse, said nothing.<br>\
 The old Reverend Jacobs, who had just ventured out of doors after the usual Sunday Sermon, was nearly as irritable as Mamma when he espied of Bluenose. `,
` The room was silent enough for Mush's patterings to resonate around the scaffoldings. Heronimo was amazed to see `,
` Kohlrabi wondered where the stars had gone to. It upset him that their absence reminded him of failures long past. He shook his head energetically and focused intently on the presence of clouds. The menacing—looking stormclouds were still there, and so, for that matter, was the Moon.<br>\
 O glorious, maddening orb! Kohlrabi couldn't believe that he had known her once — touched her — heard her scornful laugh, her pleasure—sighs. For even moons go on vacation, you know, and Kohlrabi had met ours when she came down to Earth in the form of a maiden, one maddeningly hot spring. `,
` Mister Wiedersehen continued smoking his pipe nonchalantly. The little elephant balked at this impertinent display of phlegmatism. Where was the concern? the alarm?<br>\
 \"People keep telling me I must get Employed, Sir,\" the little elephant repeated, its voice (as ever, in such situations) plaintive and small. \"But I am quite sure that I am meant to be a Performer, possibly an Actor, and definitely a Songwriter. Ever since I was little I have also desired the quiet leisure time to make my own Stews. But it has not come yet. What can I do?\"<br>\
 This time Mister Wiedersehen did not even bother to blow a puff. Dismayed, the elephant began to bawl. As it burst forth its faucets, gradually its reserves of fear and sorrow diminished, a wondrous feeling of calm filling the resulting void. \"Why,\" the little elephant managed to choke out, in spite of the snot clogging its trunk, \"I feel so much better now! Thanks, Mister Wiedersehen.\"<br>\
 Mister Wiedersehen, a distinguished—looking gentleman of about seventy who always wore a top hat and whose expression could change in an instant from utter placidity to steely disdain, raised a withering eyebrow. The little elephant shrank back pre—emptively. \"I have merely smoked my pipe, little gray thing, and I believe you had better blow that long nose.\" Sure enough, mucus had been beginning to form an embarrassing trail away from the little elephant's trunk and towards a Rose. <br>\
 This lovely peach—colored Rose was the result of a cross between two highly pedigreed strains, a large, floriferous hybrid perpetual and a tall, elegant tea rose. Quite understandably, it thought very highly of itself, and would only speak up when its interlocutor thought so also.<br>\
 \"I'm very sorry, dear Rose,\" began the little elephant, still lachrymose, \"if I have caused you any discomfort with the products of my long nose.\" As the gray creature was addressing it with sufficient courtesy, the Rose decided to have a few words.<br>\
 \"What century is it, peasant?\" (Being so highly bred, it fancied itself at the very least a Marquise.) `,
` \"You look ill, Romulus,\" whispered Pierre. Indeed, Romulus was looking, if not painfully thin, then painfully tired. He had slept but somewhere under four hours, and, what's the worse, this had not been in the interest of any ambitious machinations. It had merely been in order that he might save money on a flight — to his in—laws, no less. Wistfully he thought of the days when he had been with Petunia, an heiress, but hard—working to boot.  `,
` \"The train was losing track of anything which would mean success or failure. It was even losing contact with the rails — or were the rails, rather, fading?\"<br>\
 Faradeh lifted her head from her grandfather's leatherbound notebook. These writings really hadn't warranted such an expensive vehicle, she reasoned, as she pried out twelve pages from their sheath. Hereafter she would be the proud author of its contents, and by extension master of her destiny. For if only she were to recite a highly specific chant of five words unto the book, it would render any further writings of hers true.<br>\
 It is a foolish thing to tamper with destiny, as any child knows. One tweak can lead to an earthquake down the line; few men are blessed with foresight. But Faradeh's pretty little head was not concerned with the future in the least at that time, and she wished to be a paper model. <br>\
 Becoming a paper model is not easy at all, as I'm sure you can imagine. Being thinned out into paper is worse than being waterboarded, and it leaves so little room for the circulation of one's heart's blood! Whyever did Faradeh wish to undergo such a process? Lust, my friend, for newer prospects. `,
` Simplex's morning routine was not going according according to plan. He had forgotten to make the pasta, accost the dishwasher, leave a paper trail of evidence starting at the loo. All of his various chores and whimsical endeavours would leave to annihilation, perhaps, should they ever be completed. The hill climbed, the tower reached, he'd be forced to wonder What all that effort had been for. It was much easier to forget, and forgetfulness was happily aided by alcohol.<br>\
 Simplex's whimsical friend Hannah had gone a slightly different route. She had decided to settle with a Minotaur. The bruises alone set her back at least two Tuesdays twice a month. But it was the odor, above all, that cut her dreams of becoming a nightclub starlet short. `,
` The Doltenbird sat up and tweeted ferociously. Its play had been thwarted, ergo it was time to make show of its feathers. Which, mind you, were lovely and iridescent; nevertheless, creatures of the skies prefer the admiration of their prowess in the air to that of their plumages, swiftly fading.<br>\
 The Doltenbird had heard all about how quickly plumage could fade away from its second cousin, the Flying Lizard. The Flying Lizard, of course, had never been other than a scaled individual; still, having shared the skies with many a feathered creature, he could authoritatively cite his knowledge of their ways. Never mind that he was often mean—spirited and cynical! Had he not preserved all his scales? Did this not leave him a large perimeter of skin ahead of all those with molten feathers? (For after beholding the Fall of plumage, he had often observed its separate components to smolder and melt.) `,
` The estate was dwindling away, apparently, under Mr. Mouse's refusal to sell Pine Hollow. Ms. Prairie Dog sniffled. \"He's been living on the hog ever since he broke our family apart.\" `,
` \"What do you mean?\", asked Delilah, shocked. His words were coming to her as through a veil; yes, he wanted to leave her, and they were many provinces away from home. The snow was falling slowly, and it was beautiful. She must convince him otherwise. There was a piece of junk shaped like a ring in her left pocket; it would become a spell, an incantation. Were he to put it on it would rekindle in his heart faith and hope. `,
` Socks were not involved in the Wonack's food—allowance: it had to pursue such delicacies on foot, cringeing its face. (And it cringed this lovely Saharan sun—burnt skin a great deal.) <br>\
 Nobody was right or wrong about these boys. `,
` The cupboard was full of mysterious things. Mere puddings and jams, one might have thought, were it not for the shimmering iridescence of the vials. This choice of glassware too, of course, was rather dubious, if not on moral grounds, limited as it usually was to sorcerers.<br>\
 It was rare for sorcerers to act in this fashion — to actually fill with comestibles their mystical vessels. But Darbon had to do it. His spirit was frightfully ill, you see, and consolation, however brief, could be gleaned from making a fresh saucerful of Jam of Blackcurrant. <br>\
 His lover Evanocovich had been completely different, prioritizing an ascetic slenderness over the temporary gratifications of <br>\
 `,
` Nobody seemed to understand how to express the truth anymore. People were feeling extremely self—satisfied, and this was causing them to act like walruses. There was a cure for this kind of thing, whispered some, who were bold. I lacked that breed of confidence, and consequently said nothing.<br>\
 My doubts were very thick, amounting to the smoke after a forest fire. It was hard to tell whether I had in actuality been someone at a point in the past, someone and not a mass of delusions.<br>\
 I could remember a dress, sleeveless, with thick white bands protecting the area before nubile young shoulders, with a plaid white—and—black skirt, with a vibrant sunflower on the torso. Handed down by a friend who had grown faster and plumper, part of a box whose contents had seemed like jewels, and how my mother and I had gloated as I'd tried on largely oversize but intriguing, often bohemian knits. `,
` The night was dark, and yet a fat finger of diffuse light streaked the sky.  \"Sometimes we see the shadow of the zeppolini of the South,\" whispered Paolo to me. He was a fragile boy of nine, who often struck me as lacking the substance to reach adulthood.  Not that this thought ever became conscious, of course, and perhaps I am but carrying over consequent conclusions; still, at the time, I recall an awareness of his extreme receptivity to my requests, and how often I would prod him to fulfill them. I had been barely three years older, but I had milked my superior understanding of the game of life undercover for all it was worth. My mother having used me, and my father having remained blissfully absent in these periods, I considered myself at liberty to use others as I pleased. Nobody had taken it upon themselves to keep my back protected, so it seemed necessary to keep many knives at the ready. There was insult of one's looks, of the other's passivity, of a third's weight gain, and so on. Comments only fatal to feminine senses of pride, and to delicate understandings of friendship `,
` The bird swooped, nearly met the bison face—first. How long had it been since Takenasin (for that was the bird's name) had seen one of the heavy furred ones? Very long indeed, and he had hoped to maintain this streak of isolation from the whales of the prairie fields. Disgruntled, Takenasin flew off southwards, back to his roost within an ancient Eaton's catalogue home.<br>\
 Takenasin's home model had once been beloved by housewives all over Saskatchewan. Then the dusts had begun, the grasshoppers arrived, and finances forced domestic ladies to focus their energies on reusing sacks of flour for clothing. The Eaton's catalogue had surely plowed on, but in those hungry days by the prairie women it had been all but forgotten. <br>\
 Yet I lie. In moments of despair it is all too easy to retreat to the golden prison of better times, and many a bride recalled the times of plenty when ordering an Eaton's brig built had not been out of reach. For the ones who felt the blow most keenly it had been three years away from the purchase, if not less, you see. `,
` Everything was fading to black, the cuckoo—birds had ceased their monotonous chanting, and Luis Montalvo finally crept out from under the garbage bin. Not to be outdone, his rival The Mouse removed the banana peel which had been masking his skin, his lips, his entire demeanour with the languor of absurdity. Now he was himself again; a confusing manifestation of nothing.<br>\
 One of his earliest memories was of screaming in the dark basement, begging to be let out. The punishment had in some way been related to ketchup. Looking back now he can finally wonder why he had reacted so strongly, acknowledge the possibility that a braver boy would have borne the seclusion more interestingly, made curious exploration instead of loud scream. But he was not that boy, and he had had nightmares. <br>\
 The Mouse, contrary to the expectations of those who heard his moniker only in the gambling rags, was a real rodent. He had tried being human for a spin in his twenties, but this had not worked out as well as he would have hoped, and back to the cheese bin it was. (The Mouse was impulsive — eager to pick up, quick to abandon.) It was by the Gruyère scraps of Madame Porcelana that he had met Luis. `,
` After the crowing of the last member of the murder had dissipated, after the last croissant's odor had become a mere memory on the breeze, Atalanta emerged from her hidey—hole and strolled forth. The prairie sun was merciless, unforgiving, and now the weak shrubs scattered upon the plain were spattered with magpies. How many Atalanta did not care to know, never having heard the fortune—tellers' chants. She harkened from another continent, perhaps another planet; nowadays her memory was never too strong on this point. But the crows were gone at last, and that was important.<br>\
 Ever since her arrival to this God—forsaken land, Atalanta had been haunted by these grim, beady—eyed figures: their sooty brows, their mocking caws. It was as if a choir of demons had risen from the usual place to taunt her with memories of crimes committed, things unsaid. For once, though Atalanta remained vague on the details, she had been a princess. Through some rude rebuttals of her birthright she had lost favour with the court, which would have preferred one of her younger, wiser sisters anyhow. But the final cause of her exile she could not recall, alas! and so Atalanta remained tormented by vague misgivings, which she focused and transferred onto guiltless birds, because she could. And, besides, crows really were annoying. `,
` The Venetian blinds let enough light in for Razjha to be dazzled. For her eyes, that is, to be seduced and blinded; for her mind was elsewhere, lost in contemplation, lost in lamentation for an unlived youth. Such cases are not rare; nor was Razjha's particularly heavy, as such cases go. It was frequently interspersed with moments of light—heartedness, of the quality which for most everyone is a rare joy. But she had been blessed with the thorn of beauty, you see, and her mother's voice had penetrated her body until she felt loathsome without it around.<br>\
 How does one grow properly? For some the condition of the weed is applicable: given space and sunlight they will thrive and multiply. Flowers of the hothouse seem elegant to myself and many other, but are they not terribly finicky? panicky? fragile?<br>\
 Once, Razjha was thinking, reminiscing without registering the fumes of salt borne unto the air, she had been in love with a bronze—skinned boy, and determined not to make a move about it. What ecstasies she had felt when their shoulders touched, what raptures — and yet it had not been the thing to express these feelings and thoughts. Her covetousness and longing, denied their proper voice, had seeped not only into her bones but managed to radiate from every ceiling thereafter. And Razjha could not be sure that it was not all a mad dream. No, this was not true: rather, even as she desperately longed to go back in time, to undo the web of her arrogance, she thought: your mother had taught you well. Had you revealed your desire, he would have recoiled from your parchedness, or taken advantage in some heinous way. For no one, no—one is to be trusted. `,
` Ultimately, reflected Prajna, this cheeseburger had not been worth thirty dollars.<br>\
 This would have been imminently clear to anybody confronted with the cheeseburger's prospect; as a matter of fact, earlier, it had been readily apparent to Prajna herself. But then she had wondered what her coworkers would think, and in a reluctant manner given the list of ingredients a second read (\"farm—fresh tomato garnishes slivered haloumi cheese of the finest quality atop a burger of peerless local beef: all this goodness within Madame Boulangerie's award—winning sourdough buns\"). Given her hunger and fatigue, her subsequent actions had been predictable, if regrettable. But now it was time for the loo. <br>\
 Sometimes when Prajna upchucked these fancy, over prized meals she would give her face a careful examination as she rinsed the vomit from each side of the mouth. Often she fancied herself a soothsayer forecasting omens as she faced her entrails. This angry  woman presages a need for help of the motherly sort; these guys desire and covet one specific thing only, and woe betide you if you hastily give it away. This is a naked woman in a bath, teaching her son how to swim. Is it important? No, no, it's time to flush and wipe, thought Prajna. The bathroom was too violent, too injured by her sin. `,
` Do you remember <br>\
 the land of the eunuchs?<br>\
 Once there they wandered, happy & free<br>\
 Now they are lonesome, far from the court life<br>\
 And sit here drinking tea `,
` Sandra felt lost after the long voyage to an alien prairie: a voyage she had undertaken naively, in the hopes that it would expand her horizons and strengthen her relationship. As it happened, she had been spoiled beyond recognition, and not even with the kinds of gifts she liked. Her face had changed, her spirit soured, her voice disappeared — and yet, this was nothing new. Frequently Sandra felt that she had courted all the depravities under the sun. And yet — how could one go forward, knowing such a thing? Of what point was cleansing, when one had acquired the wrinkles of time, been joined in holy matrimony, birthed a child? Now she was trapped.<br>\
 This was silly! She was very lucky. `,
` Rubble from the collapse had decimated the Pipsqueaks, the verdict judged. For the collapse alone had not really harmed anybody other than Flynn, Miss Masham's domestic canary: this long—suffering bird, alas, had been squashed along with its golden cage. (Being of such high purity, the gold had been exceedingly pliable.) But the Rubble had taken on a life of its own. <br>\
 It had all begun on the Monday after. Porfic, chief of the Pipsqueaks, had been in the middle of sharpening his best Pencil, as he usually did in preparation for a duel. It was most burdensome, but nearly every fortnight ended with a challenge for the throne from some young upstart. Much as Porfic hated pointless killings, he had yet spend time developing a better method of fending off competitors. And, besides, Pencil—fights were quite fun.<br>\
 Anyway, there Porfic had been sharpening his mighty Saedler, when he heard a stirring outside his burrow. Absent—mindedly he wondered whether a new family of mice had seized the occasion of the collapse to make their way in. Having determined that Saedler was of a perfect point again he lumbered up to his great pencil case to withdraw 7HB, his second—best — in case the lead of Saedler should snap in combat. Then the growl came. `,
` The April shower had streamed away from its initial violent encounter with branches, dead leaves and grasses; down the sewer grates it had plunged, leaving behind both wistful tear—drops on benches and the dark stain of wetness on tree—trunks. Lazily Leticia considered a crumpled paper—boat to the left of her sidewalk (for it was hers, as was everything in this city when she felt happy) and wondered what she would like to have for tea—time. It never occurred to her to want for a spring bouquet, for in her parents' large home the usual dining table overlooked discreet flower boxes blooming with purple as well as two large bushes beginning to bud with white. So she would see flowers whether or not the table held a vase. What Laeticia found of much greater concern was whether the cards would be in favor of tarts or meringue. <br>\
 She had found the box titled Enchanted Tarot quite legitimately, when returning a book about the antics of a family of circus bears to a wooden receptacle painted a vivid blue. The Book Corner box was one of Leticia's favourite places, once it reappeared in the midst of June. `,
` \"Your teeth are too large,\" intoned Dr. Sikza as she shone her flashlight deeper into Kathleen's maw. \"It's quite dangerous for one's health, molars of this size,\" she added conversationally, shining her light this way and that. \"You should get them removed.\"<br>\
 Kathleen sat bolt upright, almost choking on the flashlight before Dr. Sikza snatched it out of her grasp. \"No,\" she gasped. Her apprehension was extreme and sudden, but not beyond reason. None of the witches in her family had survived, thus far, the loss of any of their adult teeth. (Little Serafina had knocked out a milk tooth and lived, but that was unquestionably different.) But, as Dr. Sikza's gaze was growing more beady—eyed cynical, Kathleen realized that it would be in her best interest to `,
` The Lizard nodded its head appreciatively at Tamara's Bejoonk. The new—fangled device glittered with jewels and caught the sunlight in all the right places. Its functionality, however, remained obscure. \"And what does one do with it…?\" The lizard tapped his claws rhythmically against the table. He liked to do this in moments of boredom, especially since it put his opponents ill at ease. (While Tamara wasn't his opponent, exactly, or not yet, he had read many skin—sloughings ago that it was better to be feared than loved, and that was always applicable.)<br>\
 Tamara finished reapplying a thick white cream smelling strongly of beeswax to her cheeks and smiled slyly. \"It is up to the beholder. But, as the monitor of the Bejoonk, I must guide it wherever it goes. You see, I am its arbiter.\"<br>\
 The Lizard narrowed his eyes, a veritable feat considering the limitations of his biology. (It remained an excellent way to soothe his feelings of anger, especially since, given his scales, he had nothing to fear from wrinkles.) \"Is there any distinction to be made between these two titles of yours?\" His tone was skeptical, cold; he had interacted with many a smooth fast—talker of old, and he had observed the universal law destroying them for their arrogance in anywhere between 5 years and a month. `,
` \"Yes, Tigger has been really into keys himself lately,\" said Raphaelle confidentially. There was a nervous air to her which belied the smile and the apparent eagerness to prattle about her child. Friendliness and kindness are our retention strategies, Doreen remembered having heard many years ago in conversation with a long—ago business graduate. She'd been from one of the Eastern Europe countries formerly known as Russia, and therefore visual reminders of her attractiveness and predilection for red lipstick had peppered her social media feed just as much as student group initiatives, generally competitions, and quotes from websites which peddled lifestyle ideals.  `,
` Nobody wanted to tell Ginevra the truth about the disappearance of Monchil Manor. \"An ogre ate it,\" the old groundskeeper had grunted at her from the uncanny darkness of his TV—centred living room, a place permeated with the smell of salted pork rinds future, past and present. He had been both unresponsive and leeringly lecherous, but Ginevra had heard no better from the well—manicured mayor of Tincil University Town. She had sought to divert Ginevra's focus with a multitude of the seemingly innocuous sort of questions which reduced to jelly most college students studying liberal subjects (\"what are your plans for the future\" being the chief theme), sly compliments about her breeding, comments about the successful execution of the new library buildings (an ugly and expensive lot whose supposed bragging rights lay in their abundance of floor—to—ceiling windows). But Ginevra, having no bone to pick with reality, had remained undeterred until time ran out, and the perfumed mayor smilingly excused herself and a bowl of salad from lunch.<br>\
 Next Ginevra kept her eyes and ears glued to Professor Tomkins of her Physics Class (360: Physical Chemistry). He of the red hair and unexpected bondage necklace had let it slip, during a revision of the Third Law of Thermodynamics, that both the Principal's Pub and Monchil Manor had been his favourite haunts when old Professor Grover reviewed this very same law for him. Ginevra's fellow students had tittered at the mention of their favourite boozing place, renowned for its sticky green carpeting of today as of yore, but Ginevra had been amazed to hear the mysterious name spoken. `,
` \"What's your dream?\" the Indigo Fairy (my apologies — she was Purple) asked Botulism. To which Botulism did not respond, taken aback. He was still heavy with various things including a pint of ice cream. <br>\
 The Purple Fairy flitted here and there. \"You wish to be an illustrator. And an author — you are a fellow of the pen!\" Here she tittered, being frivolous, as many Fairies are. Botulism, not really understanding, smiled awkwardly. And once again the Purple Fairy went off, landing first upon a stool which, at her size, affected the dimensions of the world. \"You must assume yourself, you know, and let go of that nasty specter which follows you about.\"<br>\
 Botulism, a veritable scaredy—cat, did not like the sound of that. He blanched and paled. Hesitantly he blubbered: \"What… Where?\" The Purple Fairy smiled. \"In your underwear. Just kidding,\" she added cheerfully, flashing a wicked grin as Botulism continued flushing scarlet. And then, more soberly: \"I was referring to the voice of your mother.\" `,
` Owls were hooting, far from the soft glow of the streetlamps. Deer were walking, and hedgehogs sleeping soundly in their burrows. Only the amanita mushroom was silently lurching in an atmosphere of hatred and disquiet. It would have liked, perhaps, to change its spots, to lose its penchant for the vindictive. But it had grown to maturity in mid—June, you see, and a trait common to Gemini is ambivalence.<br>\
 Astrology provides answers for one subset of the world. Other, oft—times overlapping populations subscribe to notions of \"Psychology.\" The specimen of Amanita I was referring to earlier had thoroughly immersed itself in this cultural fad's belief system at an unfortunately crucial time, and seized upon bitterness and visions of disempowerment for twenty dragonfly's flights too many. Why had it sprouted in such a lonesome street corner? far from the nourishing conversation of fungi of all sorts — of any other sorts! `,
` The ridge was bloody — consequence of many unwary unicorns, many creatures severed too long from Reality and Time. They had been indolent, insular, and the Great Vole had devoured them in the first instant they were to feel worry. <br>\
 Caelan did not feel sorry for the beasts, did not lament their departed majesty. He had grown up largely oblivious to beauty and heavily dependent on limes — to the extent, in fact, that his very thoughts had turned sour. (Alas! such tales are nowadays all too common.) What he did lament was the destruction of their bodies down to the very hooves. Unicorn hooves fetched such good prices of market on Tuesdays. `,
` The fish marveled at the sky. It was probably never going to see it again, and would likely look back on this moment fondly as one of the pinnacles of its existence. Would it?<br>\
 Just then, a pelican swooped in. Its beak was large, and the fish had the strange sensation of being in a bowl of punch anew. (It had been in one once before, during its brief career in film — and, what's more, had known the inside of the PA's barely bitten honey cruller donut.) But the fish did not experience its VIP flight experience in full. Sooner rather than later, the pelican was taken aim at with a harpoon. <br>\
 Mufasa had been brought up to view the rainbow fish of the tranquil waters adjoining his home as holy. Therefore, when he espied our befuddled piscal companion's scales glinting in the mouth of the peacock as they hit the sun, he knew what to do. The statue of the Great Mariner has not been far from him all this time — merely somewhat below. `,
` Ruddy—cheeked and angry, the elf Catherine breathed desperately onto her fingers before yowling at Simon to bring her some mitts. Simon, a very well—trained poodle, swiftly slinked off to obey. The elf Catherine kept her gaze fixed on his receding figure as she jumped from foot to foot in an attempt to maintain blood flow in her lower regions. <br>\
 She could not lie: initially, the trip to The Cold Place had seemed an excellent idea. Her mind had been so troublesome lately that she had found the prospect of undergoing a deep freeze immensely appealing. Ever cautious, Catherine had naturally brought her mysterious waxy rosary; a bundle sages leaves, to burn as necessary; an arctic fox blanket. Any many others besides, but it was to the sage leaves that the elf Catherine ended up owing her life. (Had she not been `,
` Handkerchiefs were unnecessary at Randy's funeral, rendering vestigial every handpicked breast pocket accessory amongst the men. But even the women's cheeks remained drier than the Sahara desert; it couldn't be helped.<br>\
 The dam of complaints broke when the widowed lady of the house realized there was a shortage of brandy at the chiefly—punch table. \"Always!\", she cried, \"a penny—pincher down to the instructions for his own funeral!\" There was a light tittering at this inappropriate comment. It couldn't be helped — nobody present had liked the man, except Steve, his butler, who remembered the days of war in his native country and could only respect those men as intransigent as his former sergeant. The Honorable Reverend Tallowstick had been such a rarity. But everybody beside Steve preferred sleight of hand and similar diversions to mockery, and wouldn't have minded washing down the new state of the diseased with some forty proof.<br>\
 Tallowstick had been young, once, thought this period had not marked any of his acquaintances with impressions of charm or levity. He had been born sallow, unhappy, and desperately craving to make others understand the immensity of his pain at having been born ugly. It was unfortunate but true that he could not seduce women from his fulsome height of seven foot two, for his visage was as mangled as if his skull's front had been caved in by a horse's hood when he was but a babe and his physiognomy had developed accordingly. Rare were the beauties in religious school, but Tallowstick had managed to acquire the sobriquet of \"The Gargoyle.\" (It should have been \"grotesque,\" really, as nobody had ever seen him spit up water, but you will agree with his classmates that \"gargoyle\" is catchy.) `,
` It was unclear whether the sky would clear, the marmalade mellow, the scimitar be released from Rossaf's grip. But Rossaf did not at all want to release his weapon, as it happens. Though a passerby could never have guessed at the depths of his tenacity, he would gladly have sacrificed as many as two digits to the cause.<br>\
 Gilfred had warned Rossaf of the power of the scimitar; cautioned him against developing too fond of an interest in this blade. \"I was young like you once,\" he had rasped, pointing a finger at Rossaf's slick moustache. (Rossaf had not understood the meaning of this cryptic gesture.) \"I'd been engaged,\" and his voice had quavered, \"before the Scimitar of Aloom came between my Rosaya and me.\"<br>\
 This Rossaf had understood either. \"Surely you could have moved it?\"<br>\
 Gilfred scowled. \"You do not grasp the metaphor! Young one. Look not at this cursèd blade — return to school!\" But the `,
` Nothing makes as little sense as an adventure, except possibly a soup made exclusively from turnips. And yet again, nothing makes more sense than an adventure when one is bored! And, moreover, when turnips are the only edibles around, only a fool dreams of sneering at them. (It is the case, too, that hungry fools leap in practicality to extreme degrees.)<br>\
 But enough of turnips. You are here, for the moment, reading my deranged tales. For this, dear reader, I salute you. What would you like next to hear of? Tulips? Nay; let us bury ourselves in dirt, and examine the worms.<br>\
 Once, when I was young, I met a red—haired lady who decided she was sick for worms. She had been used to the sight of them crawling out after the rain, and though at first she had feared them she'd grown to glean comfort from their quiet expanse. If they could be so pale, blobby, and still moving, any depravity must be something you can survive.<br>\
 But then the Ornihonk came. <br>\
 How can I begin to describe the Ornihonk? that creature of bruised arms and jagged teeth and fur running down its skull besides? It is despicable — its conduct lamentable! — and yet when I think of it, I cannot help but shed a tear from my eye.<br>\
 What does it mean, to think deeply? To feel? I am sure I know not, being but a scold and a miser. The Ornihonk, when he honked not, let everyone and their mother know how miserable he was, whether by screaming or shedding from his torso needles laced with poison (for he was veritably a venomous sort). He certainly made all us his neighbours the begrudging slaves to his moods; for, unwilling to expose to his natural darts our children, we would run about after him sopping up as best we could his messes, having locked our wee ones underground and given them the keys to the Flashing Lights.<br>\
 The Flashing Lights had been flashing since before Grummel, the eldest of our town, was born. He told me once of his first sighting. \"I was four, I know this now, but that didn't matter then. My wife liked to know this kind of detail, God bless her, but it just ruined my soul. Anyway. I was standing in the corner of the street, a wee little box of the most wonderful—tastin' gummy bears in my pocket, when I saw one of them sewer—lids was undone. So I plumb forgot I was meant to keep holding my papa's hand, and I jumped in. This was mystery!<br>\
 Well, mystery hurt. I remember thinking I was gonna die, and startin' to make my peace with it, not really havin' much fight in me ever or summat. And then the queerest thing happened! I started hearing this beautiful singing, real ethereal—like, and really suddenly I expected any moment I'd see angels like in my sister's Christmas book, pretty ladies with long triangle dresses and dove wings and such. But I just saw lights, of all the colours of the rainbow and then some more besides. And this funny feeling began in my body, like twenty cats was lickin' at my legs or something, lickin' all that pain from prolly havin' broken ten bones in my fall.<br>\
 I still don't remember what happened next, though I sure wish I did! Every year it's getting less likely I will — I guess it was a fool's dream from the start. But I woke up in hospital, bones all fine, jist my heart a little bruised, from no longer hearin' the singing of the Flashing Lights.\" `,
` \"You're still here, you know,\" the panda said gently, his eyes crinkling with a smile. He was vast and round, as pandas are, and Endra felt safe in the shadow of his large beneficence.<br>\
 Surprisingly quickly, with the agility of a butterfly, he leapt up. The branch of the oak tree remained solid under him. Endra thought briefly of acorns, wondered how this large oak's genitor had made it all the way abroad. The panda interrupted this musing with his urgent whisper. \"Endra! What was your life before you grew afraid?\"<br>\
 And yet, Endra couldn't help but wonder, hadn't she often been afraid as a girl? Afraid at the clothesline, that she might have done things wrong; afraid when she spilled the juice; afraid of asking her father for help with math, for he grew impatient, her reasoning taking for him too long. Afraid of provoking her beloved mom. Afraid when she threw up too far from the toilet, in the night, and her father was angry. Afraid when her parents locked themselves in the upstairs bathroom and fought.<br>\
 But there had been a lot of free time, too. And her love of books had been encouraged — although she is skeptical about that, now. Did she not spend too much time reading in primary school, once grade four had begun, and not enough time with others? `,
` \"The time is now,\" hissed Fiendrick. \"You can do it, Malena! Jump off that cliff!\" His wild eyebrows were electrocuted possums.<br>\
 Malena barely shrugged, lacking the energy for anything else. All right, all right, she thought. It had been a long time since she had felt the quiver of hope uncoupled from one or other of these enterprises in which she had met with many failures. She plunged.<br>\
 The time might be now, the time could be next week. Malena stared at her reflection in the ceiling, brought the fingers on her left hand together. She waggled her eyebrows and poked her tongue out at no one in particular — or perhaps at an unseen entity behind the mirrored ceiling, an experienced capturer of aimless girls and other attractive bottom—feeders. Or simply at herself! to show that she remained undefeated.<br>\
 The day was long, the heat broiling in that white, white room. At least Malena had the good fortune of nudity to protect her from total dehydration, although whether this was outweighed by the unfortunate questions of who had stripped her, what they had had done and whether they were still enjoying themselves was debatable. Malena was greatly entrenched in experiencing her fiercest fears from intangible, unproved barracks in her head. This had for many years contributed to her loveless marriage with reality's bitter demise. `,
` \"My wife left me,\" the fattest of the three men announced sadly. Then the plump but pleasantly curvaceous barmaid passed their pan of the counter, and, distracted, he hit his pint glass against the table. \"More Sleeman's, Lucy!\"<br>\
 \"Not our very own homegrown IPA this time?\", Lucy asked with a wink. The fizzy apricot—flavoured ale was a reasonably successful way for her to increase her sales commission during Happy Hour, which only affected pints of Sleeman's and such. But, alas, Matty — for that was our divorcé—to—be's name — had not been so impressed by the tasteful hint of apricot, and in fact had been rather bummed that the Happy Hour deal had not been applicable.<br>\
 After Lucy had sashayed away, Gorman smiled slowly. \"Well, then, can I have 'er? She was always too good for yuh anyways.\" He kept his eyes on Matty as he sipped at his daiquiri. The colourful cocktails were good for getting female attention, and they lowered said women's guard too, \"seeing as they seem pretty gay,\" to use Gorman's parlance. `,
` The rabbit's nose quivered; the creature looked puzzled. Then it bounced off hurriedly. The man watching the furry beast from behind the counter at O Sole Mio chuckled. Subsequently he had another piece of tomato—slathered toast.<br>\
 O Sole Mio did not serve toast, but one night some weeks ago Gina, the new girl, had been doing her first solo \"close.\" She'd been even newer then, not privy to the grabbings and snatchings from the bread basket of yore and such, and also in a period of personal debt which she attempted to address by eating exclusively peanut butter sandwiches with cucumber. But that morning she had slept in, too fatigued for rational thought, and consequently she had chosen to bring an entire bread bag, a whole cucumber, and most of a peanut butter jar to work.<br>\
 \"I hate my life,\" she'd grumbled to the enterprising squirrel staring hungrily at her as she spread peanut butter onto her second piece of bread — and, after some consideration, onto her first `,
` \"So this cardigan was a gift from a friend,\" said the excited girl with Arab ancestry whose cartoon—colored lips were red leaning on magenta. \"And the shirt was from a local independent store. And the clown earrings were also a gift from a friend.\" She omitted the source of her black high socks featuring bloodthirsty—looking harlequins, but her interviewer did not realize this until later. `,
` The fawn blinked slowly — quickly? — at Elvira before rustling away into the foliage. Suddenly Elvira's eyelids were fluttering too, and the piper of Sleep began to play his silent tune for her benefit. Her feet began to sink into the ground… and yet she felt so pale…<br>\
 \"Quit this nonsense, Sedgewick,\" Tobias snapped. \"I told you I was willing to take a chance on ya, but this is nonsense! Overwrought, unskillful.\" Tobias peered at his client from over his glasses, frowning. \"Were you ever sober during the writing…?\"<br>\
 Sedgewick could have punched Tobias in the throat, but he'd already paid him his hourly fee. There was no need to put one's money to waste for such a foolhardy — if alluring — memory. He should just have a turnip. `,
` The clock struck Miggard, and Severina's ballgown vanished.<br>\
 Let me tell you about Miggard. Most clocks, being ordinary, have no conception of Miggard. Sundials are altogether estranged from such high—falutin notions. But every so often you come across a beautiful grandfather clock inside which figurines move at the stroke of midday, inside which figurines dance a jig at midnight. And if such a clock was made in Switzerland in the yawn of the last century, then it introduces you to retribution at Miggard.<br>\
 Switzerland is notoriously neutral thanks `,
` \"But as I was saying,\" continued the Duchess with faux nonchalance, \"the key is better than the sword.\" Peter, for whom the only blade of any importance lay in the name of the swordfish, tuned his godmother's speech out of his consciousness. He occupied himself instead with thoughts of turtles. Turtles were groovy.<br>\
 His cousin Laura, who was standing by the petunias, had no interest in tuning out the Duchess' words, despite her lack of understanding for metaphors. The Duchess' opinion of her would have great influence over her marriage prospects, as her mother the humble Curate's daughter had long let her know. \"I would never have been allowed to polish your father's _shoes_ had it not been for the Duchess,\" she would tell Laura insistently roughly every two weeks, especially when she had found supper particularly satisfactory. \"But we're using his money to live well _now_, and so…\" (here she would trail off, cheeks flushed with alcohol and the silent acknowledgement that, if they desired to maintain the lifestyle they were accustomed to, they had better begin to consider the marriage market.)<br>\
 Laura had undergone a great change over the course of her puberty, one very different from the standard development and protrusion of breasts and smaller, unseemlier elements. No; it had been a veritable crisis of the mind. First she had sought to make herself the most desirable, by fasting; and yet this, alas, proved to be insufficient for the social domination she craved. Doors were open, but no seat on the throne for her was saved. Then she decided to maintain the starvation and the excellent grades in etiquette and dancing whilst also spending more time with others. But she was not sure what to do about the talking, her inner life having been quite hollowed out by this point. Luckily for her around this time she met a devil, who was quite scandalized by her looks and willing to take the first bloom off. Laura consented `,
` Alas! The bloom had worn off, and words had erupted from Magnolia's mouth. It was a shame; it was inevitable. For she had been angry, and hungry. <br>\
 Smoke billowed from the ruins of a friendship. But what is a friendship, really? Magnolia had been raised to consider friendship an exchange of goods and services, preferably with back—biting involved. Books had claimed otherwise, but books were wrong. And so at some point books had met with the consignment pile, and the burn.<br>\
 What is wrong with people like Magnolia? Why do such wretches cheat, lie, steal, destroy? Why do they rehabilitate — or attempt to — and then raze all their progress to the ground like an abundance of sheep ravaging a grassy knoll? Magnolia sometimes wondered at this, but now she wonders no more, being dead.<br>\
 Her mother, Peach Blossom, was quite depressed when she learned the fatal news. In fact she accidentally almost ruined her perfect manicure, having dropped a glass in shock, and foolishly grabbed at the shards. `,
` The flamingo tree being ripe, Candy did not hesitate to pick of its fruits. It was not a frequent occurrence, for such a tree to bloom; and, besides, she was hungry. <br>\
 She had often found herself hungry since the Heffalunf came and stole her mother away. Often, previously, she had taken the presence of supper for granted. She had not puzzled over whether to eat hard leftover rice and bland ground beef, packaged together in inordinately large quantities, because whether it had been fresh<br>\
 rice and fresh ground beef or soup made from a variety of canned and dry ingredients, it had been there, hot and portioned out for her sisters and her. She had never had to worry about it, and she could always look forward to a good read afterward.<br>\
 Alas! In retrospect, the Heffalunf had begun to creep in early, encroaching on the rituals and confidences of a young mother. Moreover, Candy had been too self—absorbed to consider that her mother might have her own world of regrets and sorrows to address as she saw fit. Candy had merely seen her as Mother: unimpeachable, awe—inspiring, vital.<br>\
 The words of the Heffalunf had felt vital, perhaps, to her. What had it promised? Candy had not felt her explanations afterward to be honest. \"I just started the school because I wanted you to have a proper education.\" Had she not felt, then, all these years, a longing for prestige, authority — an unfulfilled certainty that she was wiser and better than the mass? `,
` \"Never mind!\", shrieked Dina. \"I didn't ask you for those shoes in the first place!\"<br>\
 Jinkel didn't understand. \"You mean you didn't want flying sandals at all? But you'd said they were the only way to the Volcano of Doom!\" Jinkel, a round—faced, good—natured soul, was completely baffled, as he always was during one of Dina's good old—fashioned rages. \"If I'm not mistaken, the information in Haggard's Grimoire corroborated this suspicion.\" `,
` Now that the rain has washed the bruised and tattered magnolias away, thought Shirin, we can play Cards. For, as everybody knows, it is dangerous to take out Playing Cards in the presence of injured flowers. They get incredibly jealous.<br>\
 Shirin was looking forward to playing cards, especially her childhood favourite of Go Fish. As it happened, she had invited her friend Frabias over to join her that morning. Well, to be more precise, she had invited Frabias over to receive the latest gossip about his irksome wife, and because his visit would warrant exercise, a good she was in dire need of. But, now that the weather had done its job, why not rope him into the role of card shark? `,
` My grandfather sat, smiling at me with his eyes of the malcontent. Guilt shuddered somewhere behind my bones, invisible in the bright room my husband and I had reached only because we had borrowed my mother's blue hot air balloon, after a series of ignorings and refusals finally transmuted to success (or so it seemed) by one favorable interaction with my father.<br>\
 It is odd how one can misunderstand words, having bathed in a mix of languages. On that day my grandfather, who seems constitutionally unable to truly listen to me, showed two songs he likes on his hand—me—down portable waterfall. I fail to remember the title of the first, which he had introduced as a soldier's song, and which to my surprise was loud with synths and electric drums. But the second, thought I, was \"It's a Shame, Of Course.\" Yet my clay Translation Golem suggested helpfully that I turn my attention elsewhere, to understand the expression I had misunderstood, and receive it rather as \"I'm sorry.\"<br>\
 In the language of my grandfather, yes, the \"I\" was first and foremost. But I had assumed it was relevant in a slightly different formulation, for \"I Pity You.\" `,
` The genie peered at Riley over the dollhouse, over the large frivolous edifice with its ogival windows framed with real marble, its miniature stained glass productions made with the utmost care by that most in—demand of London artists today, Badden Smith, its ornate wooden doors and nooks and crannies.<br>\
 \"Well, Riley! I do regret to inform you so, but I simply haven't got all day. By 9 AM you'd better have cleaned up your mood.\"<br>\
 Riley balked. \"What does my mood have to do with any business of yours?\", she asked, masking the unease she felt at the prospect of having to rely in any way upon this creature. `,
` Gemino shook his head frantically, his eyes filling with tears. \"I never did that, Steve! I never did it, I promise!\"<br>\
 Let me correct myself: Gemino's eyes were not simply filling with tears. He was blubbering.<br>\
 The day had not been so bad to start. Thanks to his deal with the Morrick, Gemino had eaten a delectable Basque cheesecake for lunch. Geraint, his brother's wife's cousin, had responded to his latest virtual chess move with a particularly stimulating ploy, which had enthralled him and provided challenge to reflect upon whilst he took a big poo. (The challenge being, of course, how best to respond.) He had also received, at last — oh, at long last! — a snail message from his long—lost lover Mira. He had thought her gone in the Vetruvius eruption of 1834, but not so! The woman, he thought with satisfaction, knew her way around a larder. `,
` Twilight began to spread over the horizon in soft strokes, like melting butter under a knife. Tzagool looked up, beyond the Laughing—bird—trees; up at the sacred distance of the sky. And fell asleep.<br>\
 Here in Carthage, Tzagool had found himself unable to slip in amongst people as he usually did, slithering around and either asking questions boldly, or whispering obsequiously. He had found, moreover, as of yet, no canvas for his worship. `,
` \"Gina,\" the old man whispered worriedly at the big—bootied figure retreating into the mist. \"Please say you'll come to the exhibition tomorrow?\" And then, more viciously: \"You'd said you would!\"<br>\
 At this the old man's turkey piped up. The bird, if anything, had gall. \"Don't let her escape, Steve! Dead or alive, she's gotta make it!\" (This was in part a reference to the time Steve's recently deceased pet hamster had been provided a seat, or coffin, of choice at the Animal Adventures: Artifice and Angels vernissage.) But Steve had already moved on, hobbling back towards the veranda, away from the ghost of a magnificent derrière's shadow.<br>\
 It was a mystery to anyone of a financially incurious nature, what could have drawn Gina to Steve for friendship. He was quite a bit older, being ripe for consideration of dentures, where she still bloomed like peach blossoms `,
` While the river continued to flow, its currents were grown weak, its algae prolific in face of the stagnancy. Jondin, from his perch in the pagoda, above the straits, acknowledged this with his limpid, motionless eyes. He was thirsty, and awaited recovery in the form of the waiter at his beck and call.<br>\
 Soon enough, Walter returned, bearing the awaited—for Long John. This in—house classic of the Beverly Wrong was known by its ardent critics as \"Frog's Spawn\"; its equally pernicious admirers, however, could not get enough of its trenchant (if nothing else) mixture of tequila, gypsy coffee, mint and lemon. As always, it was accompanied by a frog—shaped tumbler full of water. Rumour had it that Beverly herself had begun this tradition after some hot—headed fellow had ordered too many Long Johns in a row to celebrate both the attainment of his degree and the fact this his name, too, was John. Ever conscious of the need to avoid PR debacles and of opportunities to maintain her place's whimsical reputation, the penitent alewife herself had arrived at the young man's sickbed bearing a crystal tumbler of translucent liquid. John, bemused, had accepted the frog, and smiled for the camera. `,
` Once upon a time, there was a flea.<br>\
 I looked upon him, and he looked upon me<br>\
 And For a While, plain as tea is tea <br>\
 I guess we were happy, me and the flea. `,
` The two—faced man stared at me. His frontal visage then distorted in agony. \"How dare you disturb the order of my universe?\", it squealed, its voice a shrill paeon to disorder and hatred. \"How darest thou rend the drawstrings of a broken heart?\" Both of these questions struck me as absurd — and yet, you know, I have heard worse erstwhile. One former fiancée in particular, noted ballerina Mary—June, is partially — but no more of that.<br>\
 \"Sire,\" interjected I earnestly, \"I do beseech your pardon and solemn farewell. I must leave for Pene, tonight, as well.\"<br>\
 \"Farewell?\", hissed the two—faced creature, its eyes gleaming with the smoke of hatred. \"Yet how, of yore, had you begged for my company? Demanded it? Craved it!\" This last sentence he ended in a veritable paroxysm of hate, from which it took him some time to relent back to a subtle madness. Unable to defy the urgings of my nature at these unnatural workings, I shuddered, though I made this action as discreet as possible to avoid the eye of my merciless interlocutor. <br>\
 But the two—faced man breathed at intervals, first glutting himself with the air of the household, then expiring wholly. Finally he wheezed out: \"If you wished to cause me fatal pain, go on. Such target you may reach yet.\" I stared at his chief visage, baffled. Which clearly was what he'd expected. He gazed back and laughed, laughed, laughed. `,
` The sky was as brazenly red as the young girl's smile. The girl was too silly still to know any better, inured to such extremities of colour on one's face by her mother's incessant wielding of makeup and prattle. But the sky should have known better, Terrence thought. He allowed himself the luxury of such aimless thoughts often on balmy Sunday mornings. He couldn't have told you why it was so; the mere act of recalling the thoughts in the presence of another, in fact, would have made them seem perverse. But he very much enjoyed them in self—unconscious privacy, dragging on them as do aficionados with their cigars. `,
` The sun had refused to shine on Gaspard's head on that morning, and that had been the final straw. It was time for Gaspard to file a lawsuit.<br>\
 Let us set aside Gaspard's litigatory desires for a moment. Who is Gaspard? Wiser men than I have attempted to address this question and failed. My friend Claude suspects Gaspard is an alien. `,
` The trees were blossoming like little children, everywhere a new flower a new observation. Matilda looked out from behind the great distance of her sleek black stroller and imagined herself alone on a balcony, gazing at such trees but their roots implacably elsewhere, in the hallowed grounds of cities immortalized in cinema and, better yet, historical treatises. Tracts? What was the word for historians' lengthy writings again, she wondered. Her baby began to cry at that moment, and because nobody was around to look or listen, she allowed herself to cry, too. (She had thought she would sigh, to be frank, and shocked her own self when she began to bawl.)<br>\
 But a little gnome of a man — no, a gnome, with a cap — chose that very moment to erupt from under a tree brimming with dark magenta. Matilda started. Even the baby, whose name was Tim, chose to shut up.<br>\
 \"You're desperate, aren't ya?\", the gnome wheedled. \"You've been longing for a break for ages, you have.\"<br>\
 Matilda had to respond to this creature, but how? Its very presence raised too many questions. Its query was impertinent, though all too perceptive. (Matilda's own perceptiveness had diminished massively since the pregnancy had begun, so she took the gnome's commentary as the token of special insight into her state of mind rather than a logical conclusion.) \"I don't talk to strangers,\" she stammered, passing her right index speedily under each eye to sop up sooty tearmarks. <br>\
 \"So you would just let an extraordinary opportunity pass you by, Miss, would ya? Pretend you'd never experienced the feel of Magic?\" And here the cheeky gnome pressed his own green index finger to Matilda's forehead, with startling tenderness, before swiftly sallying away from the park.<br>\
 \"Wait!\", Matilda cried out. Already he was but a blur in the distance — and then he turned, and the green figure clad in blue velvet began again to near, approach.<br>\
 \"Let's cut to the chase,\" the gnome offered. He took out a cigar from his right coat pocket, a cheap plastic lighter. Lit up; blew. \"I can give you just about anything you want, besides going back in time. Riches, fame, beauty, love, you name it — I can fit the bill, pay with tip. You just got to keep your side of the bargain. Give me the kid.\"<br>\
 Matilda shuddered at this loathsome impresario and yanked the stroller slightly out of a smoke ring's reach. \"Cut the smoking,\" she hissed through gritted teeth.<br>\
 \"Your wish is my command, lady,\" the gnome said cheerfully, waving the cigar away. `,
` The dog barked at me, so I barked back at it. \"Where did your bone go?\", it muttered, this time woofing more soberly. \"Where did it go?\"<br>\
 How is a man to answer such a question, I ask of you? It was unclear to me whether the dog was seeking help, speaking to itself, or wondering about the status of its interlocutor's gnawable object with declining garrulousness. I decided further questions were irrelevant, and returned without hesitation to my operatic heritage.<br>\
 The dog was bowled over by my aural homage to La Traviata, but no strings were present to return it to an upright position. It was dead.<br>\
 We mourned `,
` \"This is unacceptable!\", screeched Miriam at the bouncer. \"I am a sexy young furling, and deserve this!\"<br>\
 The bouncer remained implacable and absent of any need to debate what \"this\" meant in the specific. Soon Miriam's pretty face was plastered upon the asphalt of London, est. 1940. It would never be as pretty again because the impact resulted in the loss of two teeth and severe nose breakage.<br>\
 Miriam was two when she understood the power of beauty. Her sister was the colour of pomegranate, though of course Miriam didn't know pomegranate at the time. But she knew that when her sister cried, people were slower to pick her up, and when they were in public people were slow to touch her. (Miriam caught on to a surprisingly large amount at this surprisingly small age.)<br>\
 Miriam was thirteen when she understood the power of cheating. Clandabelle had been the most vomit—inducingly perfect girl in school until Miriam caught her full of snot in the women's washroom. Well, actually she'd caught heaving sobs and two Mary—Janes shiny beyond imagining first. Then eventually red eyes, and runny nose, etcetera, all bewilderingly Clandabelle's, had joined the scenario beyond the cubicle. `,
` It surprised everybody when the jelly burst out from under the earth, but this sweet eruption had also the dubitable prestige of arousing the envy and ire of Ms. Monsridge. For Ms. Monsridge had been shown up — \"beat to the punch,\" as riff—raff is fond of saying. She had intended to erect a fountain at the very square of public terrain covered in blowsy tulips from whence the jelly — later ascertained to be of flavor plum — had emerged with such uncalled—for vigor and vim; in fact, she had just concluded the stage of bribing public officials to obtain their devotion to her task. \"Public officials\" being but Jim Crawley, unassuming secretary to the mayor, and devotion being directed merely towards her bosom, of which Ms. Monsridge had rather presumptuously supposed a one—time glimpse would guarantee ardor and determination vis—à—vis the building of Les Eaux de Brie. <br>\
 You must excuse Ms. Monsridge, a narrow slip of a thing who didn't understand that influence in the sphere of man requires nearly as much sexual exertion as it would require of the traditional physical and intellectual labor. But why Les Eaux de Brie, you ask? Well, dear reader, let me set the scene. On one ersatz February, mouse heads were falling instead of rain. `,
` \"You surely don't mean to say,\" Dr. Beans ejaculated, \"that the prime ingredient in this pie was potato?\" As he had been sweating uncontrollably and was the proud inheritor of a series of silk handkerchiefs, one of which he kept upon his person at all times (preferably in his waistcoat), he withdrew one of his storied silken napkins as expertly as a magician pulling a rabbit from a hat and began blotting.<br>\
 \"That is only very nearly correct,\" Frau Lili responded in a lilting, caressing tone of which it seemed to Beans that she was the supreme possessor in this world, for he was in love. \"The nutmeg is of the vital importance,\" she clarified, dimpling adorably. Briefly Dr. Beans was torn between admiring these soft, happy cheeks and cursing his own miserable body—cage. As was customary in those days, he diverted the virulence into worship. This relief of habitual self—loathing which Frau Lili's mere presence brought was another reason he'd found her easy to love. `,
` \"This building, henceforth, shall be known as Cake,\" Bilbore proclaimed majestically. Alas! not many sprang to attention at Bilbore's announcement! In fact, it is safe to say that not many were listening at all. It was often thus in Bilbore's company briefing meets. Everybody knew that Bilbore's Bright Buildings was kept afloat chiefly by one individual's family money — I shall respectfully avoid specifying, if not his gender, his name and age — and quietly loathed this fellow for his incompetence, paired as it was with good fortune so unmerited. Such is the way of the world that they couldn't have helped leaping for similar good fortune, had they seen it; should it have whispered temptingly in their ear. `,
` Mitbewohner had no idea whether he would be able to reach the key on the bedside table, but there was no time like the present to try. The degenerative disease beginning its reign with a hold on his eyeballs would soon reach his very fingertips, Doctor Anwaltin had been exceedingly clear about this as she explained the contents of the manila folder with her cool, soothing fingers on his left forearm. He had admired the polished sheen of her French manicure — Belinda also had enjoyed this female type of maintenance, in their halcyon days of romance — as she'd murmured words like \"advanced,\" \"aggressive,\" \"irreversible\" and \"fatal.\" But her lovely fingertips were far away now, and besides a mere week later he had lost his capacity to peruse fingernails. It was acute awareness of the speed with which he was dying which impelled Mitbewohner to take the leap.<br>\
 It was a leap because those new—fangled beds had you standing straight up in the esperance of Slumber. They also occupied the area of that now—defunct category, \"king—size,\" at the very least, because it had come out lately that a hint of controlled sleepwalking was just the thing for sufferers of ADHD, schizophrenia and depression. And besides, everybody slept alone now. It was simply the clever thing to do. <br>\
 It was a leap also because the cleverest thing of all was to have a sequentially levitating bedspace, and Mitbewohner knew that for the full hour following his cheerful songbird—twitter Wake—Up Call he remained at three meters above the floor. This, his morning nurse, a jovial old man with luxuriant walrus whiskers the colour of a clam, had said `,
` \"We must retrieve the nectar,\" pronounced Flibbertigib from his stately perch atop the immense honey—pot, jabbing his finger in the air at no one in particular. His perennial companion, the jester Pludd, smiled slyly and jingled his head—horns. Having heard this earnest pronouncement since the day he supplanted his predecessor, Friar Bung, he looked upon it chiefly as a trial of his versatility in amusements. For it was exceedingly boring to let the king name his impossible object and merely launch the same sort of balloon.<br>\
 Pludd snapped his finger and the impossible occurred: a fairy, a vision in bronze, flitted into the room bearing a glint of glass in its palms. \"Sire!\", the bell—like voice intoned. \"I come on behalf of my people, bearing our sacred Nectar! It is yours to hold!\" And here the little figure, perfect in its movements, bore its weighty crystal goblet to the king's very lips.<br>\
 King Flibbertigib, though taken aback by this turn of events, did not feel compelled to ask questions. The nectar, sacred as it may have been to the Fey, nevertheless belonged to him by right. It was the same for anything he might covet; to behave otherwise was unthinkable. And so the clear beverage, lime—green in colour, went down his throat.<br>\
 Immediately his eyes bulged open; it seemed he had begun to choke. His courtiers, and especially his wife, Mitton, turned their gazes to Pludd. The emotions in their eyes were varied. For the most part, the lords and ladies absent—mindedly awaited the outcome. Their heads were full of concern for the impending tithes. Only Queen Mitton's steely gaze was of any import to the future of Pludd. `,
` \"Therefore,\" continued the Marquis, gesturing to Andalusia on the map with a loose movement, \"we must grab the Spaniards by their postures.\" Another man might have exclaimed this; gesticulated more wildly; flashed provocatively in one eye. But this was the Marquis de Montfort, and now as ever Séveline witnessed his being as implacable and cold.<br>\
 As she did her rosary at bedtime she thanked Father Son and Holy Spirit for having given her warmth, before, in the form of Grand—Mère, that she might know what cold was. It was evident that the Marquis' daughter would never bear such heat in her spirit over the course of her cloistered childhood, and Séveline knew what misadventures might threaten a winsome girl thus deprived later, when she blossomed into womanhood. `,
` \"It is not sensible, the way in which men act when driven by the lust for power, and yet men in all ages have succumbed to desperate flatterers everywhere. Not to all the desperate flatterers, of course. The mighty have some standards: of talent, beauty — and at times mere sexual availability. It is true, also, that past a certain age single persons can become exceedingly lonely, and in this way more vulnerable to the false honey of sweet—talkers. Nevertheless, being by then much used to command, they will generally control the would—be seducers without fail. Despite the claims of both parties, such relationships have no victim. Both sides, disregarding their bluster, know that they have sinned.\"<br>\
 So wrote Polep the Poet after having driven underground his fancy for eclogues. Many a man hath done so to the thing he loves, through overwork! But where was I. So wrote Polep to practice his vertiginous vanity, and make it feel that it had worn the crown of splendour. He wrote, but his words were contaminated by the infamous spewings of men who had come before him, holding others in contempt and seeking glory. Often Polep faced again, in nightmare, the abyss into which he had plunged having given up hope. The abyss was almost real, and it began where the door of his educational institution had closed. `,
` The tempest had quieted, to the great relief of Alison, who could now clear away the shards of broken dishes without the necessity of dodging the more to come. She could think on beauty, with the supplementary energy this sparing of her efforts afforded her. She could linger also on the way a dragonfly's wing had once remained aloof from a sunlit windowsill.<br>\
 Alison had renounced much in her fear of disappointing her parents. One member of that clan was a little monkey named Paul. Paul had been a veritable bundle of nerves, chittering away sadly whenever he finished his banana. Sometimes he would chitter before he got to the end of the banana, but after he'd thrown its carcass away. Alison didn't understand Paul, but she loved him anyway. Except her mother had insisted that Paul had to go. This, alas, meant an end to Paul's residence in the wood—panelled habitarium she had ordered made for him in Peru. <br>\
 Another member of the tribe was Alison's lover Ross. Alison's mother had laughed at her scornfully. \"He's younger than you, Alison. What's wrong with Bruce? I think he's sexy.\" Bruce had been slightly less than a decade older than Alison, the proud owner of a business, a townhouse, ten cars, and a valuation of 3 million dollars. This last fact Alison had learned after slapping his cheek; before, rather. But none of it mattered. Ross would likely never have entered her life had she not been fleeing it in in the first place. `,
` The clown had a raspy voice, and Max couldn't help noticing that he was possessed of a wheeze also. Max had standards; he wouldn't be denied his plummy accents and velvet tones. He also wouldn't be denied his balloons, so he shoved a finger into the hand of the man with the badly painted face and ran off. He was clutching the balloon—strings tightly but three managed nevertheless to escape to freedom, red and yellow and blue.<br>\
 Dreams were more delicate than spheres of air encased in rubber; they were diaphanous and required hardly something as vicious as a needle to kill them aloft. Max had cherished dreams, once, but lately he tended to cry and drink beer more often. It had taken him aback initially, this new lachrymosity. But he was different now, and could detect in the subtlest strain of music teary motive. `,
` The corridor was lit by a multitude of owl—shaped tapers, in a truly delightful quirk of the house's former owner. Mrs. Magaccio, for such had been her name, had used the riches of a corrupt magistrate's wife to full advantage; even in death she was rumoured to be the possessor of America's choicest collection of German porcelain. For, like a pharaoh of old, she had been buried with the objects intended to continue serving her in the afterlife… Unfortunately for her butler, Simpson Todd, servants of the house had not been excluded from this category. In the final days of her illness old Minnie Magaccio had wheedled Todd into caring for her in the chambers of her future burial, and when the needles in her left arm were joined by the final shortness of breath she'd had a special bottle of sherry ready. It was Todd's favourite drink. In spite of any queer fears or apprehensions he may have harbored, by that stage, he hadn't been able to resist. Indeed, to Minnie's final amusement as she heard his goblet shatter, he vision already blurry, he beat her to the Next Place. But that was fine by her. In life she had always insisted on the privilege of being fashionably late. `,
` Everybody dimly began to apprehend that the pursuit of golden candlesticks was not the thing. It was wiser, perhaps, to improve one's knowledge of the many routes one could take on that checkered Arab tabletop game, or to learn expertly to dance the minuet. Culture would keep you warmer than logs could, many determined, and some devised plans to infiltrate that highest of society: the worldly poor. <br>\
 This rarefied stratum lovingly enclosed an elect few who had tactfully declined the standard mortal path. Instead of issuing forth lineages of sons they would come to term mere spawn, they desecrated marriage and declared themselves votaries of art. An esoteric, arcane understanding prevailed in this circle: that work alone could make one immortal.<br>\
 Some of these sought to replicate the effect of the Magenet varnish: to produce paintings so softly illumined that they would inspire awe and whispers of hoaxes. Others sought desperately to maintain the slim figures and dewy complexions of their youth, an epoch in which they had felt themselves immortal, and certainly succeeded in persuading many that they were gods. But now they were merely hollow, the pleasure that had once filled their every movement having gone to some younger blokes. `,
` \"The situation must be assessed as it develops,\" Klaufzig frowned from over his glasses. His antique spectacles were so large as to constitute a veritable gate betwixt himself and the world; he had to take them off and drink coffee before he could really talk man—to—man. But some men do all they can to avoid such intimate modes of conversation, and for Klaufzig there had been enormous joy in swearing off coffee.<br>\
 His partner at the firm, however, remained possessed of the desire to hear Klaufzig speak of the prosaic elements in his life. She was not a shining moral light, per se, but then that is not necessary for a ghoulish fascination with thumbnail cuttings. Determination is the essential thing, and this Danicka had carried in spades since her father had told her she was too unsightly for marriage. Perhaps it had been unfair of her, to bowl him over with those melons obtained on liquidation, and yet she had given it very little thought. It was not that `,
` The air was so thick with moisture that Marina positively felt she was being gagged with two wet fingers. (Wet — as if fingers shoved down a stranger's throat could ever be dry!) But time was ticking, and Marina powerfully desired to be expert in, oh — something! And so she choked back her complaints, maintaining what the perennially lascivious Herr Einfach considered her implacable, queenly demeanor; maintaining the rhythm of her steps as she followed Frau Verspäten to the Abyss.<br>\
 For many years now this abscess in the rich earth of Regnetheute had been shrouded in absurd rumour. Elves had been seem among its folds — elves — those creatures of myth, long held to be `,
` \"You wish to write,\" inquired the goblin brusquely. His spindly fingers tapped at the golden wood of the writing—desk, and Anna couldn't help shuddering as she noticed the blood caked under his glossy long fingernails. But what else should she have expected? He was of a race whose bloodlust nearly equalled yours.<br>\
 Anna gulped, looked at the cuckoo clock again, steeled her nerves: it would not do to be interrupted by the springing of the bronze bird; she must be quick. \"I need your help sir,\" she blurted out. Blushed. This was the moment in which she'd be chased away. But Providence smiled.<br>\
 The fastidious Simil Cheswick was employing a tooth—pick in the region of his blindingly white fangs. It had been a gift from his grandmother, a curio she'd acquired during a visit to elephant country, and Simil had found handling the ivory sliver dreadfully soothing whenever he was faced with unhappy individuals who wanted something from him. `,
` \"Nothing feels as good as a silken scarf on the heel,\" proclaimed Mufasarah Al Dibna. \"Repeat this gesture after me, for Allah be praised! it shall do thee good.\"<br>\
 Sarneh, the money—lender's daughter, cocked an eyebrow. She had listened to many a caged bird's song over the course of her young life, and the excessive self—belief, the sheer grandiosity evident in Al Dibna's words could only be bolstered at the expense of his woman. Men never had to deal in matters of reality, she thought bitterly; they merely speculated and dreamt of riding horses. `,
` Everybody was convinced that skimping on taxes was the new rage. They had been seduced, in spite of their intellects, by birds of prey. Guillermo's rondelle subtly touched upon it.<br>\
 \"At first, avast I was upon the seas<br>\
   But out the subtle torturer fished out me<br>\
   Awaited I the steady streams of gold<br>\
   Yet off my back she squirrelled off to Rome —<br>\
   Away, fair knaves, away!   At first avast I wait upon the seas<br>\
   And yet, the seas are yet to talk to me!<br>\
   I wait apart! Indeed wait I afloat<br>\
   Flotsam and jetsam, nearing soon thy moat   At first, avast! I wait upon the seas<br>\
   Though they are slow; though they are hard to me<br>\
   I think of all the hart I have let go<br>\
   And blood within mine heart trickles too slow\" Such was Guillermo's limited artistry: pride, alas, could it achieve but from a mother. Determined, however, he remained, and thus follows the story: <br>\
 Attracted by the subtle smell of lemongrass, he sallied on towards the tournament. Of jousting he had heard much, and especially, perniciously, from his father. But that was no reason to retreat. For safekeeping he chose only to swallow his dagger. `,
` \"The women who chase after the men,\" Fligabord whispered confidingly, \"die young.\" At this Roseaver blanched. She was not accustomed to such drastic appraisals of what was undoubtedly her situation.<br>\
 She had been young, it was true, and their union had been splendid issue. But shockingly little seemed to matter now that Friederich had not succumbed to her latest desperate cryings and beggings for him not to go. As a matter of fact she had been harbouring more thoughts of death than a ship has barnacles, or at least zebra mussels, if it never ventures into saltier tides. Fligabord, evidently, had noticed. One could be forgiven for suspecting that he wished his protégé would cherish other plans. As he swirled his straw in the deeps of a mug of liquid marmelade, however, he remained impassive. His defining element was that crocodile smile.<br>\
 Roseaver had been frightened when she'd first met the man, partly because he'd materialized so suddenly from a bunch of palm fronds. Or so it had seemed — later in their friendship he was to reveal the presence, in that courtyard, of a secret passage. But at the time of her tea with Bruce Jenkins, she had been convinced of the joint involvement of black magic and an ugly body; in her indignation, she had spilled her saucer. `,
` \"It's already almost midnight,\" the elf—witch repeated mockingly. Gastine blushed, and not particularly prettily; the red presented on her cheeks and neck like a rash. The elf—witch, of course, cared only for her bat, and Gastine's incompetency `,
` The red feather was floating, falling, falling — being snatched out of the air by a sneering lady in yellow petticoats. Tom's heart nearly skipped a beat. Would the Avenging Marigold rip up this token which had promised him salvation? No, queasily he decided, but when his younger brother Tim asked about `,
` Sparrows chirped as Luke sat aimlessly by the pond, waiting for the turtle hidden below the reeds to surface. Alas! Luke was to be sorely disappointed. Or rather, he could have been, had the bells of the nearby nunnery not suddenly begun to toll. <br>\
 The sound came as a great surprise to Luke, who had lived, as most of the townsfolk, convinced of the nuns' disappearance in the Great Massacre three years ago. If the bells were ringing now, thought Jessica, `,
` \"Move your rook,\" Saladdin muttered impatiently. He had not been at the Oasis in a while, and was angry to find himself matched for a quarter of his evening with a complete fool. By the bar Mari alternately wiped glasses and forehead with the sweat of her brow, for her dishrag had been absorbed as she tried to eavesdrop extremely indiscretely without succeeding. She had aspired to learn the tricks of the game, as a little girl, and though this interest had wilted in favour of purely self—directed pursuits Saladdin's anger now pursued her. It couldn't have been otherwise; he reminded her too much of another dark—haired individual with a short temper and a hooked nose. <br>\
 Salim came out of the kitchen bearing the Oasis special, a large checkerboard—tray of red and green grapes accompanied by a miniature board with miniature pawns of cheese. In bygone days the pieces had been carved out of kolbasa, but times were lean, and now they tended to be sad circles of low—quality pepperoni and bologna. Mari, who often longed for a taste of the rook of old, gave Salim a glance more mournful than was strictly necessary. But it felt appropriate; she was hungry.<br>\
 \"Your order, sir,\" Salim said smoothly, depositing the platters to the left of Saladdin's opponent. The quiet smile of appreciation that lit up the fat man's face in that moment enraged Saladdin beyond anything he could say. He almost snarled, in his anger. `,
` Today the Society of Rat Poetry was convening around a large wheel of cheese, in a nod to the conventions of chivalry. Bradibant, the ringleader, was attracting discreet mockery from his regular guests — those who were quite aware of his proclivity for birds from other continents, for today he appeared to be wheedling a young ostrich over the array of cherries, the cheapest dry food pellets available in stores, and tea. Bradibant was ever exhorting his guests to bring tea and food pellets, and his guests were ever bringing the least desirable pellets possible, probably because they saved the good stuff for Renoir's. Bradibant had his suspicions — how could he not? He was a clever man — and periodically this slight sneering of the group combined with a subterraneous awareness that he had lost the love of his life fifteen years ago (an awareness which began to surface whenever he enjoyed brandy in a company which included at least one beautiful young woman.) This mélange typically led to Sunday tears after a weekly demeanour more somber than usual.<br>\
 Aphid looked around forlornly. He was no longer sure why he had accepted the invitation for tonight. He still held a grudge against Bradibant for having virtually ignored his self—composed rat poem (as opposed to declaring it the best thing he had ever heard? Aphid wasn't sure what outcome really could have been satisfactory) and the rest of the company for having failed to grant him sufficient attention, adulation, and interest. `,
` Nothing bothered Fluewig the Snail so much as the implication that he had been a fool, and pursued aimless projects, and wasted his time. As a matter of fact, this delicately delivered accusation was wont to ruin his day. Unfortunately Fluewig was often himself an indelicate courier.<br>\
 For some years he had avoided the pains of inadequacy and despair with whatever it is that snails eat — I don't know — consumed in excessive degree. He had also attempted to find himself a snail wife, as a backup, in case fame and fortune his endeavours were not sure to follow. (Not that we can have yet the pleasure of viewing a complete endeavour of his.) In short, his fumblings at life had been adolescent and puerile. It was time to go home. `,
` Émile had just confided to Zarg (for she had asked whether, at this Portuguese Restaurant, the tips were good) that he was a mere busboy, although he expected to be promoted to waiter within a month or two. <br>\
 \"But, waiter—to—be,\" leered Zarg, chops salivating, mouth—appendage moving, \"what if you wait your whole life?\" A question which made Émile, already awkward at being interviewed by an alien, choose to retreat into oblivion. \"I'm only eighteen, ma'am…\", stammered he. Zarg soothingly whispered praises of his honesty, further blandishments, and he was off on the speedportal which arrived as if by the poor boy's contrivance. Seeing him aloft, Zarg thought once more of spiders, and how soft their silks were.<br>\
 Once upon a year, Zarg had been irresistible. In 1384 the English poets had sung their praises, laboriously, and Chaucer (if not his ghost) had dedicated her a sonnet. But, alas, even aliens age! and now 'twas she not the  creamy silk, but the dark arachnid. And yet so it was: and she was nothing if not deliciously crafty. Perhaps it would not be Émile's blood, but she would feast tonight!<br>\
 Visions of cream cheese desserts, of shrimp sautés, sauntered before the shy 2000—year old girl. Briefly she considered eastern Europe, currently war—torn, and caviar pearls. Might it be time to move….? But her American ordeal was not yet over, though she lived in Canada. And so Zarg took the tunnel which led to the CN Tower when she heard the tone. `,
` \"Sire,\" Lord Graham—Binterly hissed, \"you cannot do that!\" Then, realizing that his fingers were still wet, he reached for a handkerchief.<br>\
 In the high—box his Aunt Cecily continued to peer at the festival—goers from her loupe, gawking whenever she caught sight of two lovers squabbling. This was a sight more common than you would think, for it had been a difficult April; and those who were, unlike Aunt Cecily, unmarried could afford to consider anew a different way of life. `,
`  The archway of Thewait's palace hall had been laboriously engraved with the name of every wight whom History had seen fit to commemorate. There were other voices calling, now: requesting just treatment, fairness, unwillingness to participate in bloodshed. But then as now there was an obscene compulsion to watch the obviously unbalanced, a fascination behind which, in part, lay this cruel whisper of wisdom: Watch and ye will learn what not to do. Still, there was the joy in it of watching a child who had never been told no, nor beaten; who remained uncowed in a thousand different ways. Watching Thewait gave his councillors this sort of pleasure, and this was why there had been no treasonous plots as of yet.<br>\
 It was commonplace back then for the rich to be fat, to be required never to be hungry. In court none but subtle young courtesans need concern themselves with their figures. \"False!\", interjected Mowbray at this point in his reading. \"For my gluttony I have been ceaselessly tormented by the Bishop of Ghent!\" A large tear rolled down his interminable cheek, hid itself noiselessly amidst the endless folds of jowls. He trembled, readying himself to howl in anguish, and the room shook in anticipation. It was his favourite of all his private chambers, for in that decade he presided over a great many, and so part of what trembled was his bejewelled icon of the Virgin Mary.<br>\
 Swathed in lapis lazuli, she began to be encrusted with sapphires as the eye travelled away and upwards from her humble foot. `,
` It was a commonplace, rainy sort of April Monday when Quintana got out of bent and, at the proper time, failed to go to sleep. Immensely and immediately this impacted the poor woman, her schedule being very tightly regimented, and the first symptom of the horrors and travails to come was the resurgence, from her skull, of the mare named Pete.<br>\
 Pete had been raised in a proper stable, you know, but alas the stallion who sired her was of a stern, merciless temperament. Consequently Pete, from foal to further, was raised to believe that sugar cubes were sin and silence was everything. How could this fail to distort one's desire to neigh?<br>\
 Quintana had been a youth still when she met the shy filly who couldn't neigh. Her bus — it had been a school bus — had reached the necessity of stopping for gas, and this had been quite far from everything else going on. So the stable it had been, and Quintana had seen this sad little horsey pacing the lawn. `,
` Jeremiah Siddon stared down the Pardoner. \"What might ye be tryin' to sell me an indulgence for?\" he asked, probingly, somewhat belligerently. Jeremiah Siddon's day had been hard, and he was almost certain that his wife would not have supper ready for him once he got home.<br>\
 The Pardoner smiled obliquely. His long fingers kept entwining, untangling, incestuously joining once more. \"We are all but poor sinners,\" he placidly intoned. Siddon cocked his head, as if he were expecting to hear more. But the Pardoner had resumed the smiling in which Jeremiah felt he could get lost, the smiling he was scared of because he knew he had nothing whatsoever to do with it. In the early days — the thought came unbidden — Susan had smiled at everything they did. When he caressed her fingers, when she touched his hair, when he gave her an orange. It had come all the way from Sicily, the merchant in green had told him — and, for his love—lit Susan, he had shelled over seven shillings gladly. `,
`  Jack infinitely preferred Europe to the saguaro cactii of California, or so he had thought. His recent discovery that the Plague was coming back to Europe had abruptly made him miss the clean heat of the desert, the prickly but distant green warriors. To his great surprise, tears began to prick at his eyes. He was still clutching in his left fist the notice simultaneously of sanitation warning and termination.<br>\
 It had been the Friva job which had brought him into Europe in the first place; he had circled the continent a couple of times, previously, but `,
` Once upon a time there was a little lad named Tim. Tim was tall and slim and would have much preferred Jim, but his parents cared not much for his laments — and neither did his purse, on the one occasion he showed up to a government building an the price for changing one's name on all official ID was revealed to him. But this is all irrelevant. My concern is the following: people must know that Tim killed Jim.<br>\
 This poor Jim was no stranger to Tim. Many a secret, over the years, had he told him as the two neighbours grew tall and slim on the same street, of Avenue Hill. Poor Jim! to have been given the name which rang with such allure to the desperate Tim! (He'd been `,
` The visitor came quite unexpectedly. The Franklins, with the exception of Mary, had all convened in the parlor for tea. It was a good thing that they were of strong constitution, this family, otherwise quite a few bone china teacups might never have seen the light of day again. For the visitor was fearsome, with his hornet head and human eyes and knitted brow. Under different circumstances, Mr. and Mrs. Franklin would have been grateful for the silence he had brought upon their ever—chattering daughters.<br>\
 Perhaps the visitor would have stood in front of their tea—table forever, staring, the tiered display tray of triangular sandwiches reaching the height of his pecs undisturbed until the end of time, had the Franklins maintained their silence. But Mary had finished her solfeggio practice at last, and down the staircase she bounded. Hunger had enthused her — now surprise made her shriek. `,
` Mimsy, Chimcee and Borogo trod softly along the tawny path, whistling their walking—song in good cheer. They were on the hunt for berries to eat, and yet their hungry bellies were no cause for sorrow. For the day was beautiful, and they were feeding on that peerless nectar: the dreams of the young.<br>\
 The Cloudberry Fields had once sheltered bison, tall grasses. Now bison could be seen once in a lifetime, one per viewing, sailing at a distance like a prehistoric lord. But cloudberries, though small, were plentiful — and so, in June, whenever the rains had come, were the delicious snails.<br>\
 Nobody had found them particularly enticing for anything but their shells for as many generations as there had been barely any bison. But Chimcee was never up to anything good in the kitchen, as his mother would say. In the case of the pickled snails she merely raised an eyebrow, for her son's silliest concoction yet was on its way to earning him a Bison Handshake from the Mayor. `,
` Frank the Thirteenth was far from having counted on this outcome for his diplomatic mission. His wife Fatima, in accompanying him, had been meant to provide youthful attractiveness and social skills; to convince her to join him on the journey to Istanbul, he had dangled promises of exotic sights and silks rather than of full—body transformation into a pig. But, alas, the modest Fatima had ceased the port of the hijab, and begun to oink. `,
` The command from Lord Vesnuvius had left its hearers ambivalent. For one thing, it was much too hot, on that stifling day in mid—June, to think of murder. For another, Lord Vesnuvius' pronunciation of \"caviar\" had been unsatisfactory — and yet, having never so much as sniffed at sturgeon eggs thus far, could they veritably be sure of what they knew?<br>\
 Hummingbird, the one of the assassins—to—be who had previously chiefly served as disgruntled royal gardener, frowned. (He was nicknamed Hummingbird because when he smiled, his `,
` Lukas reclined lazily, paws outstretched; meowed. It was all Trinity could do not to snarl at the self—indulgent feline's sight. How many fish corpses had she carried off the scene — some, mind you, with her jaws! — whilst this misbegotten creature curled his whiskers and picked crayfish shell from his teeth? It was infuriating. There was no doubt in her mind now that their employer, Mrs. Fritz, wished to make her suffer for some reason or other. For Lukas had so egregiously lolled about right under the elderly ostrich's watchful perch. Oh, Mrs. Fritz always seemed to be reading some romance or other (generally featuring a brawny lion, or tiger, or other large mammal with some lithe scaly creature temporarily protesting against his embrace), yet any time Trinity succumbed to the urge to scratch behind her ear with a hind paw,  the self—satisfied spinster cocked an eyebrow and warned her that public scratches were unseemly. There was more of the same whenever Trinity, trembling with the shame of one of the many past embarrassments which haunted her every Tuesday, let out a little yip.<br>\
 It was now only Friday, however; long enough since Trinity's last subtle spell that she typically felt lighthearted and gay. Therefore, as she lapped at the cool waters of Mrs. Fritz' frog pond, she tried to keep gratitude for the disappearance of the taste of fouled fish at the forefront of her mind. `,
` The grasses in the meadow seemed to billow in the wind, a thousand narrow little sails, as the Stricator approached. His head bloomed with rotting leaves; his arms were outstretched. Natasha shuddered with fear, the uncontrollable trembling oddly bringing her thoughts into better relief. She was unlikely `,
` Sylvester's grandmother huffed and puffed, making a great show of it, at his house of grass. These mighty winds displaced an errant ladybug which had been resting in the thatched roof, but otherwise left no trace upon Sylvester's masterwork. The little boy's heart might have burst with pride, had he been used to feeling such a thing. But he had been brought up very strictly thus far, and all that bloomed within him was a stifled ember of satisfaction.<br>\
 Grandmother Bishorn smiled frostily. \"Well, that's a solid structure you've got there,\" she granted. \"Try making it larger next time.\"<br>\
 Now, I must admit, had she burdened Sylvester with either disdain or too glowing a review of this first work, she might have nipped his architectural enthusiasm in the bud, and thus by the age of twenty have redirected him to drink. But this bowl of porridge was just right, and the little lad next invited Ms. Bishorn to witness the christening of a free—house. Ms. Bishorn blinked rapidly as she realized her grandson was holding a bottle of champagne aloft, visibly intending to smash it against the door he had engraved with feathers. For once in her life this venerable woman was speechless. <br>\
 \"Don't worry, Granny,\" Sylvester had the audacity to say. \"Papa does this with every ship.\" `,
` Susannah was surprised to find a man hidden within the bronze bull, still young and none the worse for wear for what she naturally assumed to be forced captivity.<br>\
 \"Please close the door, miss!\", exclaimed he with a worried air. \"Please do hurry on! I beg you to keep the secret of my being here, on your honor!\"<br>\
 This bemused Susannah, who had not supposed she had much honor left to contend with anyway. Still, she obeyed the youth in almost every particular. Instead of speeding onward she crossed the path sideways, foregoing the rest of the trail of sculptures for a stone bench on a grassy knoll. It was pleasing to sit in the shade of a large aspen, to cease to worry whether the rest of the large metal figures contained people, too. `,
` Sanska did not care to belabour her point to the miscellaneous crew of Pastiche—Mongers. With the delicacy necessary to preserve her glossy new manicure, she put the housing offers back in her grandfather's suitcase, began closing the many clasps and latches of that smelly leather thing. The Pastiche—Mongers had moved on to their illegal cigarettes and futile efforts at making smoke rings by the time she slammed the door.<br>\
 When Sanka first heard of the Pastiche—Mongers, her reactive disbelief rapidly gave way to hope. Here were creatures who did not simply mow lawn and make money! They created lives and stories of their own. Wriggle, for instance, wanted to be famous for his judicious touch with funerals. Éloïse had wanted to be an undertaker since she was six. `,
` I was assured by Normand that the gingerbread no longer formed a hazard. Having thanked that trustworthy butler, I returned to my evening coffee. My sister Celine repeatedly signals to me the regrettable impact this habit will have on my health, wealth, and lifespan, but thus far, I am sorry to say, I have been spared with respect to all three. My horse, Nitwick, would certainly be in poorer health to—day had I not taken up my nocturnal caffeinations. But I could not simply look forward to our ride as I added to my cup, as was customary, two eggs (raw) and one sugar. The affair of the gingerbread was troubling me. <br>\
 That morning as I had continued my latest painting in oils, the seamstress Switherina had rushed into my studio in a state of such disarray that the very brush I was holding shivered with pity for her. Unfortunately this burst of sympathy led to the ruin of the Duchess of Olixo's nose. Serena has long been a bosom friend of mine — she began calling me her dear brother when we had lunch together in that exceptional place, the Order of the Bleeding Heart Boys and Girls' Seminary — and so I grew fairly cross that such fine work on her face would have to be redone. A beauty even in her fifties, she is justifiably vain; but I was speaking of Switherina! I had just shot her a severe look when she shrieked at me with an utter lack of decorum: \"James is dead!\"<br>\
 I was uncertain at first whether she was referring to James Murray, the cook, or James McTavish, her no—good brother. Switherina's worksmanship with a needle being in a league of its own, I had consented to take on her services in spite of the dreadful condition of having to provide room and board for her revolting relative. `,
` Selif addressed the Raja Sufna with what seemed to be the right amount of reverence. Part of this posture involved addressing not the raja himself, but his fingers, which were heavily ringed and clearly ill at ease with the fine jewelry for which they had grown slightly too small. \"Great One of the Thousand Suns,\" he whispered — for, in the presence of the Raja Sufna, only whispering was polite —, \"I am sorry beyond belief to inform you that your third eye is calcified.\" `,
` The white ball rolled nonchalantly into a space formerly occupied by dust and perhaps crumbs, but undoubtedly under the bedside table. Ramón frowned. He didn't like it when the future Mayor pursued his favourite toys into such unclean reaches, but then again he wasn't fond of sweeping, either. As a personal compromise he lifted little Trottins away from the danger zone and into his crib, mere seconds later throwing the ball in after the boy. Only then did he dust off his smoking—jacket. For Ramón, I might as well tell you, had to go to a party. <br>\
 His employer, the lovely Ms. Vivica, tended to blur business and pleasure. The nannies she hired for Trottins' safeguarding and edification were selected either on the basis of their chess skills — Ms. Vivica had trained her inquisitive mind upon world domination via this classic game far before the age of ten — or their looks, for Ms. Vivica had long chosen to forego amorous relations with her husband, the Mayor.<br>\
 Gossip abounded, and yet the Mayor, it is safe to say, was not concerned. He had not much cared for men or women in that time of life when both crave curious respite via carnal entanglement. Eventually the need had arisen to take a matrimonial vow, for one could not take up the mantle of Mayor without one. Dutifully he had provided an heir of his own, and occasionally he would pat the head of this child. But that was as far as his interest in family life would ever go. `,
` The crab rolled its eye—stalks at Beatrice the hag, but this did not shut up Beatrice. She was remarkably open, perfidiously full of things to say.<br>\
 \"Well, little crab!\", she exclaimed. \"I see you are all uncertain as to your current whereabouts, and longing to visit a blowhole!\"<br>\
 Just then a passing seagull intervened. It had heard much of UNESCO designations in Newfoundland lately. \"Crustacean!\", squawked he. \"For blowholes, the dungeon of Bonavista's the place to be!\" `,
` \"Ingrates, the lot of them,\" muttered Hoffsin bitterly, stubbing his cigarette against the ashtray. This tarnished silver—plated amorink winced, barely perceptibly, and then returned to the world of inner musings it wandered off to during such gigs. Previously the amorink had hosted seafood bites on a shell well—oiled with sesame oil in preparation, but the parties for which it had been hired to do so magically appeared to vanish once he turned forty. Had it had something to do with the economic downturn? the loss of his youthful glow? Amarinks, living longer than humans, have more time to settle into the illusion of their eternal youth. But unemployment and the eventual begrudging acceptance that ashtrays were wanted plentifully served as a vigorous reminder that old age was nigh to the amarink we speak of, Joe. `,
` It was awfully dark in the hallway. Corrin hadn't expected that. Usually Mrs. Devonetsky set a whole army of candles ablaze for him, so he wouldn't feel lonesome on the way there. Corrin would have felt quite uneasy on account of all the trouble Mrs. Devonetsky was going to had it not been for the brass dragons. Mrs. Devonetsky had whispered to him once, \"Look. Look at these beauties. You see their veins moving, under all that marble?\" `,
` The last firework, a splendid orange, round affair, interspersed with upward whizzing, made way to a re—lighting of the lamp—posts and rounds of applause. Some small groups, separate from the mob of grateful villagers, finished ice creams, glad—handled dogs, verified time—pieces and beckoned children onwards. But Navarro wondered alone, and in silence.<br>\
 Navarro had not seen fireworks for many years now. Come to think of it, he had not had a beard back then, let alone his two signature braids. He had been at the amusement park, with a girl—friend he'd thought he'd loved, and it had been one of the nights of the International Firework Gambling—Morocco festival. `,
` The sky was an opalescent yellow, if such a thing can be believed. Butterflies of a great many shades of red fluttered in and out of the fronds which served two chimpanzees well when it came to modesty. But our concern lies with Hunter Bill, not with the chimpanzees. <br>\
 Hunter Bill could lift a fifty—pound woman in each hand. (He'd exemplified this feat with two pygmy sisters in Tanzania.) He could ride a mare as well as a seagull, for he was a man of unparalleled persuasion. (Seagulls grew as large as seals for him. This miracle would take them a day.) Best of all, Hunter Bill could make Russian Napoleon cake. And today, he had decided to sandwich eight layers of pastry with custard of chimpanzee egg.<br>\
 Hunter Bill was awfully perverse in his stubbornness. He didn't care about the miracle of mammalian evolution, the joys of the birth canal. Mere hunting had long since grown too easy for him; what's the point of sneaking up and running when your prey, enamored, comes up to your feet? So Hunter Bill had turned to Science, and decided to apply his skills of persuasion to Nature to create a world of change. Being somewhat religious, he decided to emulate Noah by getting two of each on his giant Jeep. `,
` \"Richard,\" the nixie said sternly, wagging a finger with a long and oddly sparkly nail, \"you mustn't give up on the hunt yet again. Have a conscience, young man. Grisonhelda might be dying!\"<br>\
 Indeed, she might. Richard could say nothing for certain about the conditions under which she was being held prisoner, but rumor had it that King Privius XX had veered far away from the courtesies of his ancestors. And, besides, even if she was benefiting from the respect warranted by one of her stature (a royal five foot eight), the luck of liberation would likely not come to her side through mere diplomacy. Mere coincidence it might be, indeed, but Prince John of Barovia had yet to produce any peep or sign of life to the citizens of his native land after ten years of \"captivity\". The Maid of Isinglas, for her part, would surely never see her cousin the Queen again: for she had been of failing eyesight when she was first captured, remarkably dependent on spectacles, and that was now twenty years ago.<br>\
 Grisonhelda had been missing from Gent for twenty days now and Richard shuddered at the thought that these might well have been prevented had he not been taken violently ill with epipescalia the night before, and then trembling violently in The Old Duck Inn's finest bed instead of occupying his usual spot by his liege—lord the Baron Horzig on the battlefield. `,
` Traurig scowled. Tibblin was late again, a fact which had not eluded Rothko, either. Rothko, who was standing guard at left of the bronze door Tibblin watched from the right, was starting to deveop very specific ideas for Traurig's reeducation. There wasn't much Tibblin wouldn't do to you when he got mad, unless you were his sister. Rothko had deduced this principle over years of yearning to be like Tibblin in his alone time. And this reverie and reverential analysis really was confined to his time off the job, because whenever Rothko was around Tibbin he wished there was a more pleasant bastard around to do the job.<br>\
 Grave—robbing was no piece of cake, requiring as it did the strength to dig deep and raise coffins but moreover ingenuity, discernment (which body to parse, of Death's fresh brides?), and a healthy capacity for improvisation. Sometimes Rothko felt like leaving the Tragic Trio (Traurig had dubbed himself and his two acolytes thus over a brash pint of whisky in L.A.); it was never too late, he would reflect, to sift for gold amidst the other miners in scriptwriting. `,
` The power outage, the bards proclaimed, were due to the collision of a rhinoceros with the Court Magicial. At this Andrew caught Jackson's eye and theatrically raised an eyebrow from over his wineglass. Jackson would understand the significance of the gesture. They were both cynics who preferred to remain discreet about it, for the sake of appearances, for they were neither accomplished nor rich.<br>\
 Luckily for this dynamic duo, a pugnacious elderly woman was keen to undertake some investigative journalism. She was very limber for her age, and had managed to snag a spot right in front of the bards' platform. \"How the Hell did that gray thing manifest in the Court? What are the palace guards doin', twiddling their thumbs while such a creature is endangerin' the prince?\" Murmurs of assent and support for her statement had begun to circulate in the throng, rising up like smoke from a kindling bonfire. Then that agèd dame did a somersault, recommended that the onlookers subscribe to her series of gymnastic concerts, and mysteriously skedaddled away. As onlookers wondered how she'd disappeared so quickly, and some gave serious consideration to the possibility of trapdoors, the rhinoceros in question came in to the Square. `,
` The list, as the well—fed page informed Spirulina, was already exceedingly long. Would she care for a slot at 4:50 am?<br>\
 No, Spirulina was quick to say. The bard's expression changed slightly then, and he hastened to invent a possible spot between 3 and 3:30. Spirulina, who had travelled for days and nights within the innards of a tiger to reach this place, was not particularly pleased to hear this. She chuckled, because she could not afford to display her anger. At that moment the thunderstorm began, and the Cat came in from the corner.<br>\
 Spirulina had met the Cat last year on her way up a dark street corner. It was remarkably polite, was her first impression of it, for though it had been drinking straight from a bottle of Champagne it offered her a sip when it noticed her looking quizzically at it.  `,
` Regrettably, there was insufficient cloth of gold left in Venice to clothe all twenty thousand of the condottiere Alonso's men and slave girls. (The slave girls, in spite of his legendary lasciviousness, barely numbered a hundred. This was because Alonso's preference was for selling them in France once they developed a first wrinkle. The French, as he occasionally reminded his dog Aretino, were fond of many odd things, and accepted decaying females with arms opened as wide as their jaws gaped for aged cheeses. During these finger—wagging times Aretino would gaze soulfully at his master and wonder when this superior man would throw the ball.)<br>\
 Alonso, unlike his rival of Urbino, was not to be consulted by peasants at the best of times. Pietro the soothsayer had not been told this, not in a way that he could understand, and so he managed to climb up the garden wall of Alonso's spectacular marble villa with blithe unconcern for his safety. While Alonso fulminated about cloth of gold and slapped the blue—eyed slave Valeria for the insolence of her suggestion that he try cloth of bronze, Pietro was marvelling at the richness of the tapestries in his hallways. Miraculously, or perhaps rather because it was a feasting—day, these hallways were remarkably unguarded. `,
` \"Never forget,\" remarked Herbert the Hummingbird in between gleeful sips at the hibiscus honey proffered in plastic cups by the new visitors, \"that we are exceedingly clever, and could achieve anything we put our minds to. I mean it!\"<br>\
 Walley the Weasel listened to these words glumly, and I am sorry to say that instead of taking them to heart he took out his general illness of being on a little girl wearing the unusual accessory, considering the sweltering summer heat, of a jean jacket bedecked with ruffles. He was able to access this fashionable youngster's toe for a chomp because she was wearing sandals. Many tears ensued, and to make a long story short, Walley fled the scene through the funnel dug by Molly the Mole's great—grandmother when she was hale, young, and desirous of a taste of the tropics.<br>\
 In the dampness of Mole Cave Walley felt a great deal better. He had not realized how grating Herbert's well—meaning words had been to him, and how he'd longed for silence. Not that Walley was a wicked recluse — he could be as tender as Lin the Lamb, at times — but he had picked up a great deal of bite in his large family, growing up, constantly having to compete for the remains of chickens and so on and so forth. Mercifully Walley had grown big and strong enough to hunt down his own chickens, and leave his parents' scraps alone. But one night, having said good—bye to his friend Lin and promised to bring him a radish, he was caught by Tim the Trapper.<br>\
 Tim the Trapper, being fairly incompetent at hunting — perhaps it was a booze thing — had been relieved, beyond all doubt, when the government decreed that citizens were to be awarded some moneys when they rescued maimed and otherwise injured wild creatures for the Zoo. `,
` The Toucan Two's Council was in full procession, the same painted ponies as before doing their best. \"Grandmother,\" I whispered, \"the woman by the table with no chairs?\" To tell baldly what had drawn my attention to this woman scared me, but it was her lack of head. There was hair, all right, and it may be that it perched on a skullcap. But of nose, cheek — even skull —, I saw nor hide, nor hair.<br>\
 My Grandmother responded with a fear I had never before heard in her voice. It was not shrillness, and her speech was not tremulous, but I felt a seriousness which chilled me even more than the sight of the ghastly figure had.<br>\
 \"That is no woman,\" my Grandmother said very quietly. \"That poor, wretched body had been Brought Back. By a Necromancer, almost certainly, unless there is in the land a Wizard grown so corrupt.\"<br>\
 As uneasy as I felt, I could not see what was so bad about the Brought—Back. It was simply sitting there. The Werewolf we had encountered on our way to the tavern had been by far a livelier threat, no pun intended. My Grandmother, sensing my confusion, continued speaking even more quietly than before. In fact in my left ear I could feel a light spray of spittle, which, even though I loved my Grandmother very much, repulsed me so that I almost forgot about the creature in front.<br>\
 \"Imagine it was my body there, Pip.\" <br>\
 \"Grandmother!\", I protested. Although she was an extremely hale eighty—year—old, she started talking as if she was going to die tomorrow sometimes, and I found it very upsetting. And, besides, if she worried so much about death, surely she could start by stopping drinking? Wine, I mean.<br>\
 Grandmother smiled sadly. \"Not like that, Pip. I'm saying, imagine that was me. My body, doomed to lumber about in service of some wretch who hasn't the courage to do his own dirty work; who dares defile hallowed graves.\"<br>\
 \"Hallowed?\", I asked. `,
` The rushes were plentiful in St—Helen's Pond, and the night air, for once, fragrant. Lilies had descended upon the water overnight. Or, rather, they had escaped the confines of their former tight globes, and wafted now their pleasant odours for a time all too brief.<br>\
 The Forester came here each year. He told his sister, Jemima, that it was in tribute to their cousin Sarah, who had turned up blue and swollen in the water's muddy bosom at the time of life when she ought to have been rosy—cheeked. Jemima supported these pilgrimages whole—heartedly, for Sarah had been a sweet girl, if too driven by the demands of her — and here Jemima would blush demurely and refrain from loosing that vulgar colloquialism unto the world. Jemima's attempts at demurity aside, she didn't mind the Forester having a rosy—cheeked gal to think of when nights got lonely. No real farm wench could compete with a dead girl of lush, eternal beauty, and Jemima was quite happy with her situation as it was. <br>\
 Her brother was her sworn protector, and he shared his little shack in the woods with her. It was perfect. The only thing lacking was a living room. Jemima had been so awed, upon her return to Kranzen City, by the arrival of all the new `,
` Nobody was particularly keen to break the news to Derringer. The sky was festooned, as far as the eye could see, with banners of celebration, gold and green as the prince's hair and eyes. Fireworks would begin any minute now, going off with the great bangs which startled racoons and made old Cressida fear for her bat. \"He hunts his earwigs with echolocation, you know?\", she'd mournfully informed the Mayor of Quai—des—Os last year before the great saltpeter display in honor of King Bevolio. She'd been right to worry, too, for she had barely nursed the poor thing back to health in time for Saint Bartha's Day. (Bartha, upon her unjust burning at the stake, was joined by dozens of her reverent airborne admirers, who left behind memorable amounts of guano and shrieks. The chronicler Devon of Perth did not let posterity forget that. But the malicious nickname \"Saint Bartha of the Bats,\" first sprung from his indolent lips, took on a holy significance he could never have expected it to.)<br>\
 Derringer, the prince's butler, had succeeded in falling asleep on the job. One could have blamed the season, for it was an exceptionally hot summer, but such was neither Derringer's intention, nor lot. He knew the Case of the Missing Butterflies had been taking up too great a chunk of time from him, and especially at night. `,
` The saltshaker shaped like a fish wiggled its tail enticingly. Garnet frowned. She was not interested in this kind of tomfoolery. When the feisty saltshaker waved a fin in her direction, she gave Quicknick a withering glare. Soon the saltshaker was immobile again.<br>\
 It was in Quicknick's nature to desire to attract at the very least the attention of fresh young creatures. Perhaps if his parents had not been a pair of thieving goblins, and rather a pair of social—climbing green—ones, the result would have been the same. As it was Quicknick was remarkably adept at attracting the ire of young women, and at remaining immobile for their slaps. I can't claim that the juvenile goblin much enjoyed being hit, but, as he rightly assumed, he was unlikely to have their fingers touch him under any other circumstance.<br>\
 It was unclear whether Geiger cared for his apprentice's hijinks. It was unclear whether Geiger cared for anything but the flowers in front of his shop, which were remarkably well—tended to and had gone from wimpy little seeds and bulbs to a marvelous scented array of dizzyingly diverse shapes and colours. Also for his runs, which were the rituals of his evenings and Saturday mornings. Quicknick would get the chance to interact with Geiger's old lady fairly regularly after Geiger had tightened his shoelaces. \"A workout,\" she would huff, carrying some broom or brush or rag or other, sweat gleaming on her pungent brow. \"Why don’t you try cleaning up this shack for once?\", she'd puff, then hobble off like an oversized dust mote. Not that Geiger ever seemed to notice. Seeing those two on a regular basis helped Quicknick to swear off matrimony. `,
` Taksen the Tiger wiped the floor with a smidge of sadness. He had not expected Paul the Parakeet to depart under quite such unfortunate circumstances. Privately he suspected foul play had been involved, but then Taksen would hold such suspicions for every situation in which he did not get what he wanted until he reached the age of forty.<br>\
 Taksen notwithstanding, Paul's departure would undoubtedly have taken the monkeys aback, at the very least. They had grown utterly reliant upon his twitterings to remain safe in their movements about the jungle, and especially Taksen's corner. He had developed a system, he told them, for predicting the tiger's movements. Ir was based, he fronted, upon the orbits of the stars. He had made this claim because astrology had recently come into favor in the court of the great orangutang Ossoon. In reality he knew very little about celestial geometry, and a great deal about his regular games of Faro.<br>\
 Not a body, nearly, had thus far discovered Taksen's predilection for games of fortune. Or, rather, many a body; a very great many a feathery body which no longer remained alive. First there had been Harry—Hummingbird, adept at Poker; then Marc \"Mangy\" Macaw had fostered the tiger's love of Backgammon, incensed it to new heights. Tekka the Turtledove, player of Roulette (she had inherited the board from her grandmother, a reputable croupier), had committed the same fault as the rest of her predecessors: one day, she had let Taksen lose. `,
` The ball hit Severina's head with a thud. It was fortunate that she was made of Mexican Alpaca and some solid runes, else this blow her very well may have felled. Something inside the alloy woman's head clicked as her smile turned upside down, registering her surprise and fear in primitive fashion. Severina's sister model came with a veritable worm of a mouth which could fashion itself into a squiggle, an O, a wide grin; but Severina knew nothing of her successors and their various superb attributes. She knew of her Master, John Figanuss Vicer, and of her duty to keep him from harm, and that a rotund and heavy object had just tested the durability of her cranial machinery.<br>\
 John Figanuss was delighting greatly in such tests of his new acquisition. His latest mistress, a coy negress by the name of Susanna, had possibly attempted to give him the Evil Eye upon realizing the busty nature of his new bodyguard; he still wasn't sure. Certainly his father, the ever—youthful Lucius, had been excited to learn of the `,
` In the jungle nobody was liable to consider niceties, at least not these days. Perry—Parrot had considerately flown over Maury—Meerkat to her favourite part of the nearby beach — he could because he was a giant; it was her favourite because, she said, the echoes in the seashells there sounded like voices in song — only to receive a scratch on the back for his pains. Inticle the Iguana, more troublingly, had seen `,
` Sicily had been a letdown. Herbert the Heron had imbibed insufficient mascarpone there, and failed to make an impression on any beguiling, long—lidded lizard. Still, he was dying to have an opera experience, and so it was paramount today that he purchase some binoculars. (Opera glasses, it turned out, were insufficient for today's high—flung aerial galas).<br>\
 Herbert's first exposure to opera had happened across an ironing board. In a rare moment of interaction with clean but rumpled linens, his father had turned on a tale of love and vengeful passion to while away the hour. That this tale had been sung in the highest, most ridiculous pitches known to the land had taken Herbert quite aback. He'd always considered his father a humourless fellow, known to retreat into his cave for days to study the finer points of clam—hunting. `,
` Increasingly Simbog thought about leaving his current environment. The sense of tradition, ritual, was growing stifling, and he was no longer fond of tea.<br>\
 He never could have imagined growing tired of the steaming beverage. His grandmother had introduced him to black tea first, the mug in truth a vehicle for heaping spoonfuls of sugar. But each time the drink would be accompanied by tales of ginseng, matcha, ginger, and various mysterious herbs of which she had drunk in Japan, when she was young and teaching English to polite little round—faced children possessed of a soft disdain for her ilk. For the first time in her life she had been surrounded neither by the over—involved, nor the deferential, and all had been new. In her free time she would visit strange open buildings, gardens brimming with twisted shrubberies, and drink tea.<br>\
 Simbog was initially frustrated by the lack of treasure in these tales. He was enamored of books about pirates at the time, but he did not expect criminals fond of planks and beer to feature in his grandma's recountings. He just figured more excitement and exotic colour should be involved, and probably more people. In his mundane daily life even the stubby—fingered cafeteria lady who seemed on the verge of developing a mustache was worthy of mention. Still, eventually, he began to wonder of what Grandma Regina next would speak. `,
` Coltron twisted the intruder's arm behind his back. Unfortunately, the intruder did not seem particularly bothered by this maneuver, so Coltron had no choice but to pull out a knife. It was blunt beyond belief, of course, and Coltron had long known it was time to invest in a whetstone. Nevertheless it glinted ominously enough in the dark for the intruder to emit a frightened gurgle when it reached his throat. <br>\
 Coltron was fortunate enough `,
` Jingo dangled the almond croissant in the middle of the table. It vaguely resembled a floppy penis. \"I can't accept this on principle,\" he declared. \"They shouldn't look like they were sat on.\"<br>\
 His henchman, Bingo, wisely chose to agree. Privately, he thought the pastry extremely enticing, rich with butter in a soft way that indicated it was far from stale. But Bingo had not been hired to air his opinions about such things. His purpose was to make Jingo look cool, and to kill people.<br>\
 It was unusual for such an aggressive chain—smoker to be so squeamish about murder, and yet even the clean usage of a garrotte was wont to make Jingo wince. Only once in his life had he mustered the nerve to kill with a pistol, and the result had been sufficient to dissuade him from purchasing bullets further at his cousin Tim's.<br>\
 Tim, a swarthy man with handsome stubble distribution and one gold molar, was notorious for never having faced a hold—up in his lone gun store at the end of the thirty—first highway between Yecina and Peningula. `,
` \"Please think about the guys being emotional,\" insisted Seraphina,\" 'cus this is something that really sticks in my craw.\" She was about twenty—one, or perhaps forty, depending upon the light you considered her in. It was impossible, with a discerning eye, to avoid his lack of consideration for her. Most men, when enamored of a woman, have a pedestal to place her upon; but this man, having slept for a long time prior to meeting her, had to greet her but the howl of a wolf. Now he was still adjacent to her, but sleeping, many pints of \"Soft Charlotte,\" piquant in its raspberry—bubbliness, having served him as lunch. <br>\
 He had hoped to amount to something, once, in the realm of Achilles and thunderbolts; just now he had spoken, a mere day ago, to a coworker interested in making a mansion out of beets, and held his attention at a work function for the lengthy span of forty beets, measured in cucumbers. This coworker, a dedicated and forthright man, intended to base his entire novel civilization upon root vegetables. Disliking fries, he had dismissed out—of—hand potatoes.<br>\
 His mother had been a truly remarkable mermaid. Though none of her branch had been especially seductive, they had possessed exceptionally strong muscles, and used these to bring males such as actors and dreamers to shore. Consequently. `,
` Every year, on August 18th, citizens were permitted to jump off the quay for a period of two hours. This year the allotted time would last from twelve to two. John grumbled to Peter that this meant death to his undisturbed period of lunchtime luxuriation, and Peter nodded, flicking some ashes off his cigarette for good measure. Really John wasn't bothered at all: he relished any opportunity to remind those about him of the many perks his recent promotion had brought. And, besides, he was sure there would be plenty of nubile young women to launch themselves into the canal then rise back out, gasping. `,
` \"What I want, I want now,\" yowled the tom—cat. Given that he was perched atop a trash—can, and it glinted in the darkness, he looked slightly imposing. It was a pedestal of sort; his listeners just had bags of garbage.<br>\
 One female, the survivor of more than her fair share of scratchings and fierce pawings, cocked her head quizzically in this tom's direction. Vast experience had taught her not to raise meow if what she had to say was uncomplimentary, challenging. She half—wished there was some scavenger about to ask what she was thinking, but it was right about the time when the fresh new hire at Bocaccio's threw out leftovers into the scrap—pile. Plus every stray about town knew by now that the special on Wednesdays was puttanesca, and that Bocaccio's never skimped on anchovies. The tabby with the scars about her eyes peered more closely about her, discerning a couple well—fed Persians in the darkness. It made sense, she supposed; their owners must be sipping sherry in nearby apartments, turning a careful blind eye to the feline treat of a night—time wandering. He was a very handsome cat, after all. `,
` \"It's quite alright,\" whispered Gianni. His hushed tones, Marcia realized, had been meant to induce reassurance. Had she been pregnant, they would likely have misplaced proper labor.<br>\
 Marcia looked at her empty glass of wine, at the empty bottle on the countertop. Bad luck! Second only to the disgrace `,
` The procession was as bizarre and unappealing as ever, full of inappropriate symbols writ large and coloured in various shades of red. Privately Shleniel shuddered and cursed those wretched minds that dared to bring their pineapples in public. He had seldom felt less inclined to visit the one in his keep.<br>\
 True, pineapples had once been coveted, by those of his wealthy race. Men had sent their gold, and their lessers, in hunt of the fruit that shone brighter than any jewel at the dining—table. A lengthy period of democratization had entrusted a far greater share of the populace with increasingly tasteless descendants of the spiky marvel. And then, both tasteless and odourless, the Illness struck.<br>\
 Kiwis were the first to be affected. No food recall alert could contain the wretched fuzzy creatures with teeth absolutely; thankfully their size placed them on par with rabid chipmunks. But  `,
` The moon was half gone, a fruit neatly sliced in half. It cast an odd trapeze of light upon the bedsheets in the darkened chamber. Only Laveen was awake, thinking. <br>\
 His latest order of twelve gallons of lizard's milk had `,
` The uproar coming from the dining hall was horrendous. Kromick shut his eyes in pain and attempted to focus whole—heartedly on the sensation of his thrice—corned feet being massaged. Pert, a Noribian captive, was especially good at tickling his bunions.<br>\
 In the kitchens cats were the heralds of anarchy. A shipment promised to be greens had in fact produced no end of yowling, as soon as the sleeping pills wore off. Not that the wenches in the kitchen had any clue about the sleeping pills, nor were ever like to. Only little Maeve had managed to escape the initial onslaught. The Tyrwin cats had been hungry. `,
` Portia the Porcupine screamed loudly as the boiling water drooled over her left paw's skin. From her office Hady—Heron helpfully inquired \"Are You OK?\" A civility which happened to infuriate her roommate. <br>\
 \"No, you weasel,\" she hissed, caring little for the familiar false sympathy. Those alleged researches into her degree of pain were simply the Heron's way of covering her ass in case she was in need of first aid or dying. Still, she knew it: she was Being Rude. The Heron, who would not have lifted a feather `,
` The Council of the Squirrels could not have reached full swing yet, it was certain, for the nuts were not yet out. At present the bronze bowls in front of each Council member gleamed, but they were empty. More than one Council member was evidently irate. Representative Hazlock kept staring at the ceiling, waiting as if for some divine handouts; Senator Plimpton's tail looked even less bushy than usual. `,
` The rain continued to permeate everything in a thin smog. It refused the people of the village even the small courtesy of cleaner air. For dirty, that was how it felt to breathe in such a humid daze.<br>\
 Robert Higglenot should have been more joyous in spirit, he was sure, as he wandered up the slopes of Eller Bean and towards the Frobishcope. It was time to purchase a charming gift for his darling baby nephew, and he was done with work. But Higglenot had a constitutional disdain for enforced social niceties, and he was not one to dote.<br>\
 The visit to Frobishcope coincided with the planned trip of one Cecilia Abcot, seventeen, to purchase a novelty plum cot. Cecilia was particularly enamored with this item of furniture because she had learned of her sister Denise's pregnancy at precisely that fruit size of foetal growth. And Robert Higglenot was particularly enamored of Cecilia because she was young, of good breeding, and had smiled at him like a horse. He had no better way of saying it, really. She had smiled like a horse, and it had been extremely dull sitting next to the ultrasound—awaiting vastness of his sister—in—law. So he had made a show of being extremely attentive to the old cow, and as soon as she trotted off to the examination room he neared the young woman who looked so like an attractive colt. `,
` \"Nobody was in the Citadel, Sir,\" Officer Spät reported. He was a tall, thin man with a thin scraggly moustache, and something about the set of his mouth suggested that he had long ago resigned himself to disappointment.<br>\
 Colonel Schreibtisch took his news with a slight salted cracker. \"We can't know for certain when lava's been involved,\" he muttered. His words resounded with dark implication. But Spät remained nonplussed. `,
` What a miraculous moment it was when the ducks began loitering up onto the shore, back into the shade of the tree with its millions of fronds. King Layabout, looking behind him, away from the little pond lit up by seven distant lant—horns, could count seven of them now. From the water he heard a funny little clucking. To his astonishment, it was the Dervish of the Lamphreys.<br>\
 \"Mocking me, ye wonder? Yee, yee! I can't help it, son, yer like a whelp missin' its mother. Risible but also making ya half wanting to cry, begging my pardon.\" Absentmindedly the Dervish tugged at his turban. It was slightly loose.<br>\
 As if galvanized by this gesture, the ducks lurched forward, one by one, back into the water. `,
` The last pomelo had fallen to the ground; it was now besmirched with mud. This fact mattered not to Gormel. He was hungry.<br>\
 Taydin, his secretary, believed not that this desire for nourishment was genuine. She felt quite satisfied on her three—meals—a—day—and—snacks regime. She had complained to her friend Sylvie, a dietician, of the abnormal phenomena she had registered in her employer's presence. Of a man eating three whole chickens. Of a man expelling from his gullet three roast roasted eggplants, accompanied by six zucchinis, the whole having gone up in flames within minutes. Sylvie had gasped and clucked disapprovingly at all the right moments. `,
` Miles' supply of fish was exhausted. He turned to his steadfast companion of this last week's expedition, the swarthy Geimon. Geimon's supply of anchovies was as inexhaustible as the man himself; where Miles was heavily sweating and desperately longing for the fresh climate of the Niles, Geimon remained perfectly groomed and alert for new sightings of Gemmids. He was even whistling.<br>\
 The two men had met in their halcyon days of biochemistry laboratory work. Miles, bewildered that the kindly Ryonovitch had allowed him beyond his pearly gates of cancer research, had done his very best to adapt to an environment for which he was entirely unsuited. He had shown up early each day of his volunteering period. He had noted his reactions carefully. He had worn suits.<br>\
 Geiomon, though a year younger, had been in the lab for some months already on his own merits. He was very skinny and tall, like a stork, except instead of being all beak his face was a powerful vehicle for an exceptionally square jaw. Immediately his very way of being had made Miles resentful that he himself was neither smarter nor skinnier. `,
` \"I'm so sorry, Sir,\" the priest gasped, \"but we appear to have misplaced Miss Mapplethrope's tabernacle.\" Miss Mapplethorpe, who'd been observing this exchange from the balcony, was thunderstruck. A tear began to roll down her left cheek, only one, but the sadness brewing within her withered old frame threatened to overtake her as a jug of cider will an overeager orchard lover. `,
` The zebra, eyes lidded, attempted a gentle gaze at the sun. Sindtar the elf laughed as the animal yelped in pain and ran off, the Helm of Perthoos remaining by its former reclining—spot.<br>\
 Sindtar wasn't exactly rolling in dough, but still he'd made a pretty penny convincing various visiting animals to accept bets most decidedly not in their favour. It was the fast—talking from his years as a criminal defense lawyer that came most frequently in use: the mesmeric energy required to convince a party of twelve and a judge to accept your version of the truth. He still rued the day Queen Titania had intervened in his practice, all but forcing him into this petty charlatanry… And yet, this was the order of things. No matter the Queen's claims that he was a bastard mongrel, disbarred of the right to interfere in human affairs with the mischief of Faerie unearnedly at his fingertips. This had not mattered one wit to her previously, neither over the course of his extensive education (which had begun with a Bachelor's degree in Microbiology, least magical of all subjects), nor his serene seven years of practice witnessing nigh—on the most depraved aspects of human nature. Faerie, in parallel to the world of mortals, had adopted a need to blame deeper truths on some misleading aspect of the surface. `,
` \"My cat is very small,\" the little man said gravely, \"but I trust you shall find him very friendly indeed.\"<br>\
 Moysenes swivelled his neck — one of the longest thus far recorded in the Kwegan species, as decreed within the Book of Epochs — left towards the bowl of water on the floor which prompted the kitten to lap so contentedly. He was a fine specimen, glossy and red and liable in no time at all to be jumping from willow trees onto Mr. Vandredas' sun—roof. There seemed to be energy emanating from his tiny paws.<br>\
 Moysenes shook his head nervously. His days of thinking he could See things were confirmed behind him. He was on a daily dose of amanita mushrooms now, to kill any such nonsense from the ground running. `,
` The geese squeezed in together around the pillar, heads hung tall, varnishing feathers with as much dignity as they could muster. One of them who was approaching his middle age, George, noticed his somber mood and wished desperately for a tankard of ale. Or, barring that, a modicum of coffee.<br>\
 George the Goose had not always been so introspective. He could credit the one—and—a—half hours of meditation he now performed daily with his marvelous new awareness of the inner workings of his mind. But once George the Goose had been a flower of impulsivity, ever spectacularly shedding petals (for there were disasters) and hoisting new ones. Once he had robbed a goose lady growing slightly long in the beak of a hundred ponies. Briefly had ensued a period in which he trained his abduction victims to jump through burning hoops. He had just hit upon the scheme of painting the ponies white and bedecking them with ill—begotten horns when the Mounties caught up to him. (Being dependent on horses for their transport, the Royal Canadian Mounted Police was highly alert to crimes against the equine community.) `,
` Somehow nobody could remember what his name was. He was short and discreet and either he was in the washroom or he had already slunk back off into the \"Warning: Squall Alert\" weather. `,
` The angry lynx pounced on its prey. Alas, what it had believed to be a mouse was nothing but a pile of leaves `,
` The little boy looked around at the expanse of the vehicle, turning his head this way and that, hands occasionally in motion and lips consistently parted. Though he knew it not, his parents were riding the Terror Omnibus to deliver him to a goblin.<br>\
 In the end it had been an easy choice, both of them earlier having exhausted their supplies of uneasiness and conscience in the earlier stages of deliberation. Margrim, a gaunt, pale man, showed every reason for abandoning the babe in one look—out: he was hungry. Margot, her belly being rounded, had obtained a greater supply of kumquats from the Poverty Governor. On account of her having been beautiful, once, he had even come to their hovel to \"deliver them personal.\" He had delivered a pinch to her now—bony bottom, also, and in her humiliation at not being able to say a thing she had burned. Everybody had heard, somehow or other, the tale of high—minded Larissa, reliant on poverty handouts, who had scorned the advances of her local Distributor only to find all her future deliveries cancelled. It was disputed whether that frail figure had managed to reach Timbletown, and her estranged father, after all. Those who had shared her quarters, a trio of fellow underpaid seamstresses,  `,
` The lively strains of music washed over Hecate like a balm. She had been much sullied by the indignities of yore, or rather of that earlier afternoon. To be more precise, a mere twenty minutes ago in the evening. It was remarkable how one draught of eldenberry cordial modified one's sense of time and precepts for living.<br>\
 Had Hecate and her familiar struck upon the amulet earlier, they might in truth have missed out upon all in dignity. They would have been greeted like kings by the daimons of the amulet, and treated to orchids and wine. As it was, Hecate's familiar had experienced a most uncharacteristic urge to indulge in caviar — the tomcat really did not tend to be such a luxurious sort  `,
` The haze of disgust lay on Qzwartek as thickly as the humid air did in summer, or, in winter, his favourite rabbit—fur coat. Qzwartek tried to manoeuvre his way out of it: he snarled, he shook his wrists and fingers, he jumped up and down about the room as if he had been convinced that he was, after all, a rabbit. But bunnies were calm `,
` It was at midnight that the right side of the bronze mouse's ribcage sprang open. This ritual revelation kept uncovering something different; only once had Stephan seen a squirrel clambering towards a bluebird's nest. On one memorable occasion he had been presented with a rather debauched mermaid lying amidst the remnants of an impromptu fish stew (evidently the water had reached exceeding hot in the shallows of that beach `,
` I was warned by Frederick K. Baubel that the intruders would come at eight PM bearing wrenches. This was false; they arrived at the promised time wearing trench coats, hands displaying only gloves or wedding rings. Suddenly I was privy to a gathering of gentlemen.<br>\
 \"Attention!\", declared the foremost amongst them, a befrocked ginger whose vestments had evidently been painstakingly embroidered over no less than five months. My chief seamstress, Tina, an immigrant from some country where the full name of which Tina was but a sliver `,
` Nobody had believed the bell would toll for Amandine, at least not so soon that the croissants were still fresh. I myself had just left the staff room, having snagged a contraband tomato, when the alarm rang.  My coworkers looked glum; I, thinking of lettuce and bacon, couldn't fathom what the matter may have been.<br>\
 \"Hugo!\", Dean Finnicker bellowed. I was surprised to notice his hair still covered in oil. He'd excused himself from the presence of myself and Kissick after the big spill, and it had seemed his destination would be the sauna room, the place which concealed a most powerful head jet spray. `,
` The clock struck twelve and a horde of barbarians erupted from behind the full moon door. They were of varying sizes, beard lengths and colour, but all had the lust for murder in the eye. Johnson shivered and ducked behind a rhododendron bush. He dearly hoped its pink blossoms would provide sufficient coverage.<br>\
 Johnson had known for some time now that with the clock not all was well. Where once jolly elves, short and dapper, had come out with invitations for afternoon tea at the terrace, he now witnessed increasingly angry series of creatures and individuals escape with the eagerness of those in hunt for… something. <br>\
 It was not mere bloodshed they craved, that much was certain. Having claimed first blood from a sparrow, the red dragons (a species as small as dragonflies, their near relatives) had proceeded to dig in odd geometric figures. The antelopes, once the jackals they had slain had also been devoured, seemed eerily intent as they rummaged through the bones. Even the marsupials `,
` \"It appears that your signature is crooked, Sire,\" muttered the Eagle's right—hand man. He was an individual with the propensity, when sufficient funds were entrusted onto him, to exert an eye for detail with rigor. Hurt feelings and thousands of dollars in reshoots meant nothing to him. This was a man with vision, and hence it was lucky for the Eagle to have caught him.<br>\
 Lucy had had nothing much to do with either of those two until the tornado came. Once she was out in a world ravaged by storm she cried into her coffee (a paper mug of which was now her sole possession) and dialed the Eagle, for she had met him and witnessed him preening his fellows when his name was still but Sherbet Jones. `,
` Jovio shook his head in disgust, dislodging only a couple of the pixies in this fashion. The remaining ones merely dug in harder, some employing daggers in their quest for greater purchase. Jovio would have howled had he not known of the Golem's presence at the shadowy altar ahead. For the principal condition for remaining in that mighty being's presence was to keep the Silence of Death.<br>\
 Jovio had been amazed to learn that silence was a physical quality in the Underworld, and he certainly hadn't expected to learn such a thing from Horro, his mortal nemesis in Grade Eight. But such was part of the lesson he learned when Horro, having been denied Jovio's beloved brisket sandwich, bashed his skull in against a wall of cement. As blood spread down the pan of wall preceding the Enriched Program's Boys' Lockers, Jovio's soul sank down to the abode of Pluto. Yet even this insubstantial quantity of spirit was immediately heavy with the Silence, impregnated with it in an oppressive, soporific manner. Quickly Jovio's soul needed to forget its memories, forget its body's dying torments, in fact to clear as much space as possible for the Silence. And, as a matter of course, it would have succeeded, like all the souls of the dead did, had Pluto not recognized in it a herald. From the soul's aura (and I assure you, every soul does have an aura.)<br>\
 Perhaps occult religions associate blue auras with the chakra of some region of the body, and some languages use \"blue\" as slang for \"gay.\" But that's neither here nor there. For Pluto the blue halo made it clear that this soul would fulfill the Prophecy of the Pixies when it turned thirty—one. And now, dead, it was only fifteen. Strange.<br>\
 Pluto cleared a space in the Silence of Death and urged<br>\
 `,
` It was an exceedingly hot day, albeit a dry one at last, when Tamino the Tiger noticed that the dead mouse was still there by the not—yet—flowering nectarine—pink rosebush. Its fur was no longer glossy with the sheen of fly saliva, of course, the days prior having been long with rain and sun. Now the corpse was dark and matted. For some reason unknown to Tamino the flies had left it alone at last. He did not in the moment notice, but afterwards wondered whether there had been maggots. On the first day Hellena—Heron had told him, after all, of the fly eggs in the dead creature's eyes. But today was beautiful at last, with nary a cloud in the sky, and Tamino had in his cellar a delightful bottle of the Ariosto Aardvark's blood—wine. So he looked at the mop—head hydrangeas to the right of his lounge—chair, these pale fuchsia blooms unleeched and unruffled by bombardments of chlorine—filled water from the adjacent pool, and tried to think of something to do.<br>\
 Tamino's erstwhile career as a lion—tamer had come to an end in the summer of 1950, when the government of Tarnatha decided that Wednesdays should no longer be days of worship. Not a single lion except for the traitor Richardheart had chosen to abide by the decreed law, and so Panacea had witnessed a substantial increase in their feline population.<br>\
 It had previously been null. Panacea, a popular destination spot, was in truth inhabited only by a select few parrot and pheasant families of good breeding; their fortunes having gone to seed, they had made of their remaining pleasure—parks and palaces a playground for gawkers. The lions, who believed in the superiority of their birthright , but not in money, presented to the Panaceans an existential crisis. `,
` Magriffe the kitten was reluctant to leave the matter alone. It was pungent with interest, and smelled almost of fish. Why were the falcons keeping a veil over the circumstances of Ainvil Arbeit's demise?<br>\
 The anaconda had long been a faithful guardian of the falcon nest, requiring a mere haunch of lamb here and there for payment. It was an improbable agreement, but Ainvil was a runt of his species, and the falcons of Innsguardia were notorious for their ease in reaching flesh through wool.<br>\
 King Masstimo the Intrepid had ordered their ancestors to be bred with talons like pocket—knives, to ease his hunting expeditions, but in their times of rest these extraordinary specimens had taken to harassing shepherds and their flocks.<br>\
 Magriffe `,
` The mouse Missal was puzzled by the presence of crumbs by his master's footstool. He had been quite certain that he'd eaten them all himself; his efficiency was a matter of professional pride. It was the reason he'd been preferred by Lord Scoundrel over his old rival, Jake of the Thorns, and more than likely the reason old Jack had taken to rubbing beer steins dry for their owners. Missal had smelled hops not only on Jake's fur, but on his breath as well. So Jake in that hazy state, blubbering to anyone who would listen that he'd \"make good\" someday, had made Missal terribly sad. He had never imagined Jake of the Thorns the sort of mouse to collapse at first defeat. But then, too, Missal was still very young.<br>\
 So were the crumbs: large and still soft, sweet—smelling. They were not from the rice cakes Lord Scoundrel had chosen to enjoy, alongside a mournfully long frown of a banana, in a nod to favourite snacks of yore.<br>\
 Missal wondered often now whether his employer was aware he could never be six again. He acted as if he'd never been told. `,
` The turtle's tail was massive relative to Grosvenor's expectations;  a full foot, he reckoned, from his comfortable seat in The Saloon. What a wonderful view, he thought dreamily. How old it must be, certainly older than him and perhaps even than him and wife number six combined (at this stage of inebriation he found it hard to tell her exact age, although he could place it between forty and twelve, and all but the R of her first name had disappeared into some mist.)<br>\
 The turtle disappeared into the shallow deeps and Grosvenor sighed at the magic of it all. He was in a fabulous mood — there was no denying it. A fog had begun at last to spare his life, his eyes, and the way forward he could finally spare from clutter. For Grosvenor had discovered his calling on this balmy eve — at last! And it was opera.<br>\
 Never mind that Grosvenor knew not how to read music. (He had ears, did he not?) Never mind that Grosvenor's voice had yet to be approved by any practitioner of the melodic larynx — did he not have more funds than many other mere possessors of vocal cords? And never mind that he had yet to sit through an entire opera that hadn't begun life as a radio play. He must do it! He would!<br>\
 To be fair to old Grosvenor, the last year or two had been deathly boring. No comets had streaked the sky, no naked beauties run laughing into his garden… and he had found himself mired in the painstaking details necessary to settle his mortgage. Why, the stress of it all had made his accountant decide to dye his locks blue! (I'm afraid Mr. Andin had dyed his sheepdog's fur, too, for good measure. Last I heard of him the animal rights protesters were still outside his house.) `,
` Nataniel gestured to the grimoire on the bedside table and shrugged helplessly. \"I don't know how to pull this spell off,\" he mumbled. \"I'm too old. I haven't got the constitution for it,\" he continued. Groaned, \"You've always had everything come to ya on a silver platter with tartar sauce, and vinegar, and everything.\" <br>\
 Hellraker grinned. Contrary to rumors by the fearful, he had plenty of teeth to grin with — all of them, in fact, remained to glint mockingly at Nataniel in the queer silver light. He could smile because he was tuning a straw on his novelty cheese synthesizer, and that was exactly what he wanted to be doing.<br>\
 In the corner of the weaselly mage's bedroom sat Rita, a thirty—one year old bartender who had never gotten over one man who had taken her virginity and then swiftly gone on to do the same to every attractive young thing in her town. Rita was still intent on releasing a series of music boxes which played the songs she had composed in her heartbreak, and it seemed clear to her that Nataniel would get around to crafting such devices out of thin air soon enough, next week perhaps. But for now, as for the past two months and a half, she would sit in the pouf in the corner of Nataniel's bedroom, or lounge in the crystal—knick—knack—loaded solarium, wearing frilly pink nightdresses and accepting at the end of each day forty gold fleeces from a beleaguered—looking bat.<br>\
 (Nataniel had inherited a stable of miniature golden—fleeced sheep from his nephew, due to complications in his genealogical line.) `,
` The image in the stained glass window was of a lady in a white wimple, a lady befrowned. There was a child in her arms, a girl, long—haired; her halo a dark grey to her mother's yellow, her left cheek pressed against some manuscript. The tourists jostled one another and pointed wherever they could: at unhappy mother, at reading daughter, at background the shade of lapiz—lazuli. One lone scraggy—haired individual, whose right arm bore a confusion of clowns he'd had a friend copy there from a sordid manuscript, looked at the long—cauterized stumps of his ring fingers. The misbegotten engagement promises had shone as brightly as the golden circle behind the mother's head.<br>\
 Jim, in the special organ cockpit, looked down in wonderment. An ogre had appeared in the church's midst, demanding no tribute, paying no debts. Its teeth were scarlet when it smiled. \"Excuse me, priest.\" `,
` The emerald earring, to Architect Goring's surprise, turned up eight days later in his favourite pair of sandals. Right on the left toe. He would have phoned his good chum Architect Dean to let him know, especially since Mrs. Dean had thrown a real hissy fit when that earring disappeared, certain that her husband had pawned it to pay off someone. (He had indeed operated in this manner previously with a ruby necklace heirloom, but it was so unpleasant to see women nagging and powerless.) Yet something told Goring he had better not. It was very queer that the emerald was glinting daintily from a shoe; it gave the impression that someone had been prowling about in his apartment, `,
` Andrew went out for a smoke, having ascertained that the grasshopper newly having their posterior to his right was in a state heavily departed from sober. To his mild bemusement, two pixies were hanging out next to the nearby sports bar. Absent was the typical assembly of fellas with drinks staring at the hockey players on the screen, and at scantily clad young bohemians walking by on the street.<br>\
 Not that the pixies were all covered up. But Andrew was too civil, too chivalrous, really, to stare. It was the pixie picking her nose who, by pulling on his beard, forced his hand. It hurt poor Andrew, this mischievous tug, and nearly propelled the half—digested remnants of a honey—and—garlic sausage from within him out onto Jeziel, a lady sitting alone by a row of records in that dark, disheveled sort of pub. (And yet was it so dark and disorderly? I later discovered Jeziel to be drinking a very sweet and delicious — her words, not mine — Piña Colada.)<br>\
 Thankfully Andrew was possessed of a backbone. He was chivalrous, yes, and so he didn't yank any of the four wings (characteristic of pixies; different from a fairy's two) out of her back direct. But he did grab her by the feet and let her dangle upside down: all actions which her disloyal pixie friend allowed her to suffer alone, she having fled at Andrew's first tremor of retribution. `,
` Everybody said the hinterlands got treacherous this time of year. It was an easy and pleasing exercise, making up encounters with some creature or other, of the deeps or of the talons and skies; it was satisfying to hear your interlocutor's gasps and sighs. Roswell knew, of course, that his uncle had never beaten a merman off his canoe; that his friend Connor's forehead scar had nothing to do with a black—crowned gray heron screeching, to his great horror, \"bihoreau!\"; that the friendly man who begged for money in front of the department store and sometimes slept there had not been seduced by a siren on the very fishing expedition that had left him half—witted and destitute. But Roswell did not mind the convention. He suspected that the truth, to his ears, would not be much better, and would leave a bitter taste on his tongue. It had been against his will, his discovery of Uncle Rick's penchant for beating prostitutes — a consequence of hanging around the kinds of bars that were temples to gambling and featured a table for pool. `,
` Russell's hairpiece, to his great horror, was coming undone.<br>\
 The lush black fur, he remembered suddenly, had come from a skunk — not from an animal of greater repute, ferocity or elegance. For that matter, why had he chosen to traffic in furs on his head? Never mind the cost — he should have commissioned the previously uncut lush hair of a virgin…<br>\
 While Russell began losing himself in such tiresome reveries, his opponent continued to swivel his hips enticingly. Such was the salsa game. Garfinkel was dressed in black, all black, save for the red bloom in his right pocket — a routine showing. Since fall was fast approaching, today's floral specimen was a dinner plate hibiscus.<br>\
 Russell had been introduced to Garfinkel at a time when the latter was but one amongst twenty children, and there was excitement in being around children at all. Perhaps even then Garfinkel had been possessed of a great fondness for the yeasty buns and berry crumble squares sold by a grandmotherly lady at recess in a musty church—smelling alcove, opposite the vast room where Russell and Garfinkel and many, many more hung their coats. `,
` The bells in the church tower tolled, tolled, tolled as the puppeteers gamely induced their fishermen (swathed in yellow) and seagull (soon the revelation would come, in the form of an egg, that this bird was female) to fight each other in wordless, brutal abandon. Under the shade of an oak tree, nearer to the wrought iron fence and to the carriages in the street than to the stage, Paunch continued to chew on his wooden toothpick. Selund had yet to arrive for their duel — and so, for that matter, had his second, a sallow—faced trombonist who went by the name of Sal.<br>\
 Sal made a tidy little living on his \"second\" commissions, the chief responsibility of which was delivering his boss' bodies back to their next of kin in as palatable a form as possible. This had been simple enough for Sal's liking for a couple of years, but a new development in missiles had escalated his need for involvement beyond mere disinfecting wipes and the occasional spot of makeup. Now, Paunch had given Sal every indication of being a bullet guy, an easy job, possibly even a survivor — his neck had the kind of thickness that reminded one of oxen, or perhaps even bison. But then, when Paunch had launched into a tirade about some noir he'd read, atmospherically puffing away at a cigar, he'd nonchalantly let it slip that the octopi would let his accuracy of aim begin to approach that of — whatever the main character's name was. `,
` Everett licked the envelope, much against his will as it was. He preferred that exposure to the toxins involved in glue to murder. Brutal murder. Infamous murder. He wasn't sure how it had gotten to that level of violent sentiment, worthy of the trashiest horror novel that never was. But this was what Felix now threatened him with.<br>\
 \"You have been warned. If you don't post that letter, I will kill you. It will be a savage murder. A bloody kill.\" For a second Felix blinked and paused, as if taken aback by his sudden burst of eloquence. Everett bit back a giggle. He hadn't giggled since Polly in the third grade had slapped him for having an annoying laugh.<br>\
 In retrospect, mused Everett as he walked over to the mailbox, dazed by the sunlight, he should have slapped Polly right back. Or something. Certainly bringing her a box of chocolates next day at recess, awestruck, in total silence, had been foolish. But Everett had discovered, on that fatal Wednesday, a terrible passion for subservience.<br>\
 It was not right to waste one's time on petting feet, sanding toenails, repeating arithmetic lessons in condensed format (and, once the final—<br>\
 Everett was jolted out of his dismal reverie by the sound of gunpower. Once he got out of the fetal position, he observed that Felix lay behind him in a pool of blood. This did not make him feel anything. He walked back to the garage where he had been held captive for five years and made himself an omelet. `,
` The magician pulled another rabbit out of his hat just then. An ill omen. The rabbit was dead.<br>\
 Fendrick's face grimaced, contorted; he underwent many variations of what could have been a smile. \"This wasn't my intention! This wasn't supposed to happen —\" and this last utterance was gasped out, became a sob. \"She was meant to be perfect!\", he heaved. \"She was meant to be whole!\" But she was not, and blood trickled down her defiled torso.<br>\
 The agony Fendrick felt, it could be argued, was largely self—inflicted. He had failed before to bring the animals out alive, and still he had persisted, without finding it within him to change a detail of the process, a smidge. He grew pale. What his negligence had borne was a despicable cruelty.<br>\
 And yet, as before, he merely tied up the rabbit body.<br>\
 And made a stew. `,
` The fox, Gilba was its name, had settled down quite cozily in the anemone shade. They had told Gilba the sea was unconquerable for the red—furred ones like she; after some giggles, they had admitted that no mammals at all in the water lived. But they had been parrots, and she on vacation. Back home she had been privy to beavers, and to the platypus singer on tour. It was from the third aria of this performer, The Song of the Deep in A minor, that she'd learned about whales. In this way she had understood her destiny.<br>\
 Gilba's uncle, a jolly old fellow who had taken to picking fights with porcupines, for want of something to do, had ceased absent—mindedly dislodging quills from his tail to gape at her, his one gold tooth glinting like a made—up bride, when she shared with him her news. \"Why, this is madness, Gilba! Foxes were not meant to live in the sea!\" His whiskers quivered briefly as he remembered his old drinking buddy, Alfose, who had lost life perhaps not in the sea, but in the nearby lake, which was close enough.<br>\
 Gilba was very obstinate when her mind was made up. She patted her Uncle Dirk's head and affectionately whispered that neither had foxes been put upon this earth to get their pelts bedraggled by porcupines. `,
` The flashing of the skies suggested to the Chipmunk that a return to its burrow might be preferable to further sight—seeing. He grabbed the pale knapsack in which he kept all his scores (as well as his bottle of gin) and kept on moving. It was a long way back to The Hole.<br>\
 The Chipmunk had left The Plains when adulthood struck; it had realized, somewhat to its surprise, that there was annoyance for it in the sights and sounds of its greying parents munching on snails and hazelnuts. There had been many enticements in wait besides independence: The Hole was renowned for its excellent food and nightlife. Moreover, education there was cheap.<br>\
 The Chipmunk wanted to revolutionize burrow systems, and was firmly possessed of the belief that for this a degree would be necessary. Its mother had not interfered in his final year of Branch School `,
` The aardvark had barely been carted away when Myosotis' manservant returned with Grunwald on the horn.<br>\
 \"Myosotis,\" she rasped. Once her voice had comported beautiful, bell—like tonalities, and besides too she had been lovely as a peacock feather perfumed with pomegranate floating on the wind. But years of cigarette consumption and of special gummies which the infamous Gordon F. always began making  with particular attention to the herb—infused butter, had decimated both larynx and figure. There was nobody left to mind this but her captive—in—chief, a brash Dalmatian which responded to the name of Poodle.<br>\
  Myosotis did not sigh upon the revelation of Grunwald's voice. Rather, she thought long and hard about whether she would take a bubble—bath next Tuesday. `,
` The lamp in the kitchen cupboard otherwise devoted to tea packages, pickling salts, rolls of foil and one mismatched French press had begun to turn blue. This surprised Aubrey. Not knowing quite yet what to do, for fear of damaging its material, which had come from India and was likely brass, she summoned little Pim, the cat that gave her apartment much of its olfactory flavor.<br>\
 Pim had been well—trained, and the ringing of the tiny bell rapidly attracted the appearance of an orange tail, followed by green eyes. The rest of Pim, being black, blended in faultlessly with the bear—pelt surroundings.<br>\
 Aubrey had been deeply in love with the man who kept bringing her these trophies, which indicated not only his capacity for a successful hunt and kill but also his patience and skill in skinning massive carcasses. Once, after a particularly vigorous bout of exercise, as they had lain together in bed and he had cradled her head, he had told her he dreamed of getting the hide of a whale, and using it to cover a truck.  She had not known what to make of this, but as ever she had been impressed by his determination. Rustig was not a man of empty threats, as she had learned the first time he beat her.<br>\
 It had been a sound Sunday morning, full of sleepiness, soft mounds of bodies still present under covers in the cubicles of that street so enchantingly draped in vines. `,
` It was amusing to watch the nubile young women preening in front of their dressing—room mirrors. Soon enough, I knew, their looks of concentration as they applied various powders, creams and rouges would grow to include furrows of anxiety. The determination with which they did up their tumbling locks, as they perceived the first grey hairs, would turn grim. Today's friendly, gossipy climate would become competitive and catty as the herd thinned; desperation at having remained when others had gone on to better things caused ageing divas to act despicably. You would be surprised to hear how often poisoners' plots had been thwarted by the mere happenstance of accidental tea spillage.<br>\
 But I, immortal fly on the wall, was today above all this. For I had met a beauteous fly, and we were to dance tonight.<br>\
 My mother had taught me its movements when I was barely out of the egg. It was the Mesmer of spiders, meant to distract those spindly predators in times of bad luck, such as when heat was on the wane and one was too near a dark corner. How the most agile and dastardly arachnids thrived on dark corners! `,
` \"Take the shield! Forget not your purpose!\", cried the Goddess in ringing tones. Rapidly her birdlike form was fading out of Artyom's view. In a moment life would become ordinary again and his focus would be diverted to his grandfather's currently boiling, infamous chicken stew. <br>\
 But no! trust not always ye olde scoundrel of a narrator! Artyom, blinking rapidly as a man still dazzled, turned his full attention to the shield, this heavy shining object embossed with reminders of the warrior's road. Sword, decapitated head of a foe, the staff of Asclepius — an optimistic and tastefully clinical tribute to the help to be provided by doctors.<br>\
 \"Food,\" remarked a voice with tonalities of smugness but the richness of jam of blackcurrant. It had come directly into Artyom's left ear, and though this was inexplicable on a day so full of gods and mention of monsters he unsheathed his sword and crouched about, looking for all the world like a crab or spider.<br>\
 Unfortunately this provoked peals of laughter. Good, thought Artyom; shrugged. Perhaps some mischievous spirit, pestilent in its wishes but otherwise, being bodiless, harmless. He sheathed his blade and began down the road to Tonto, having strapped the shield to his rucksack. `,
` Already disquiet, notwithstanding the charming locale, was seeping into Brasva. \"How long? Twelve hours?\"<br>\
 Never mind the ginger, Tigens thought. Stick to the goods. He turned back to his beverage, a mix of almond shavings and lizard nails. Tigens usually didn't subscribe to such gimmicks, but his cousin Vicky had been dying from marble lung and her doctor's odd recommendation really had seemed to save her.<br>\
 Brasva was not used to being ignored. She tossed her hair and summoned her regnant tiger. Was it not possible to confirm how long construction of the statue's right flank would take? She patted Ardislavi as the magnificent beast rubbed herself against her skirts and glared daggers at Tigens. He was not looking; he would not care.<br>\
 Tigens was scratching his left armpit thoughtfully when Brasva's pet gave him a scratch he was not to forget. `,
` \"We're all quite determined!\", confirmed Quincy excitedly. \"The right cards have found their way into our grasp!\"<br>\
 Earl Nimir evidently did not feel the same. He dabbed the letter he had been dabbling at throughout the meeting into a blotter; produced a candle and some wax. His signet ring had cooled by the time they prevailed upon him to provide an answer.<br>\
 \"Your prospects are entirely dubious,\" he began. That would have been all, but Marquess Wiedersehen shot him a look which suggested he would cease the Earl's current permissions to visit his Italian properties at his ease. \"The girl is an amateur at best. I have no desire to inject funds or time into this silly enterprise.\" Having spoken he blotted at his rosy forehead, too, this with a monogrammed lace cravat. It was more dignified that way, he considered, than with something his Nurse Agatha had always persisted in calling his hankie. Nurse Agatha, for that matter, had made his skin crawl too many a time for his liking. Ever since his education began he had been at pains, by his conduct with the other young lordlings, to erase any memory of and future claim to the name Babykins. <br>\
 Countess Rause, the only woman at that long table of ivory and ebony, smirked at him from behind her ostrich—feather fan. (The feathers were there in a standard gesture of mourning for the third husband, a man she had loved for his willingness to raise her from the lowly rank of Baroness.) `,
` Moonface slurped hungrily at the soup. She could have done many another thing, she knew; from abstaining to eating delicately with a spoon, or even pilfering the cutlery. The Witch's was particularly fine — suspiciously so, even. But here Moonface was, inhaling beet—and—chicken broth with unwholesome verve, as though stuffing her belly would open the dark purple curtains, or remove the eerie wooden owl from its perch upon the dusty grandfather clock, or make the boy who had inspired her to undertake this journey love her.<br>\
 \"You do realize, little girl,\" the old Witch rasped conversationally (she could no longer help her voice, it had been too many cigarettes), \"that you would be much better off learning something marginally useful like Latin? A skill which requires merely your own hard work, and patience?\" Thin nicotine—stained fingers deftly lowered delicate silver spectacles until the Witch's eyes, whites blooming with red gossamer but the irises still a piercing blue, bored unobscured into Moonface's very pores. Shuddering, she put down her bowl. Had there been a napkin…? And now she felt strangely cold.<br>\
 The Witch stood up, taking Moonface's bowl and bringing it to the kitchen. \"You know,\" she continued, `,
` It was a remarkable sight, the limp squirrel stretched out upon the cushion under an extravagance of jewels. Rubies, that flickered in the candlelight; rows of the tender—looking beads, a rosy white, which were all natural pearls; emeralds, topazes, sapphires and more besides, all winking and flashing, like the beautiful slaves of a harem who would, through flattery, hope to be freed.<br>\
 \"Who has done this,\" said Lancelot. He merely said the words; there was not a hint of curiosity, inquiry, nor even recrimination. They would whisper about his queer attitude, later, the baker, the candle—stick maker. But Ambrose, through long years of service, had ascertained this lack of expression to be intrinsic. Lancelot would have reacted the same way had he found his mother dead.<br>\
 His fiancée, young Ethel Pearlman, did not seem nearly so blasé. At first sight of the dead rodent she let out a bloodcurdling scream. (She had traipsed behind the rest of the procession to snuff out a dropped candlestick.) `,
` Her voice was low and insistent. The least she could have done would have been to keep it from also being breathy.<br>\
 \"You must,\" she repeated, in the same sinuous manner, \"give it to me. It would be nowhere safer.\" Somehow over the course of their dialogue her fingers had made their way up his long sleeve, that paragon of French millinery stuffed inside his heavy English frock—coat of velvet. Startled at how much he had enjoyed this revelation, he jerked his arm away, under the table, to a pocket. Out came his gold snuffbox, the most foolishly extravagant of his possessions. He settled himself back into a semblance of implacability with the ritual of the pipe as she gazed at him, amused.<br>\
 The atmosphere in the room with its heavy brocade curtains was completed changed with the arrival, telegraphed merely by a jaunty knock on the door before this last burst open, of Uncle Stuart. Francis lowered his pipe slowly as a defensive gesture, almost, for Stuart carried with him as souvenir the powerful odor of trout. To the general ridicule of the family, although these jabs and comments Stuart himself did not mind, being too constitutionally jovial, he went fishing every week that weather would permit. His wife, Lady Staunton, too, had sneered, and loudly and many a time wished that he would instead take up boating. But now Lady Staunton was gone, while the fishing rod and many, many fishing flies persisted. `,
` \"I don't think it's so easy, being a teacher,\" said Old Sal glumly. The lettuce peeking out of his sandwich was, besides being an unappetizing shade of dark green, wilting.<br>\
 Jerolah, the new hire, looked at old Sal with an expression of shock. This sort of pessimism amounted to blasphemy for a highly—educated young man whose second calling in life was proving that old horses could, and should, be taught new tricks.<br>\
 Thankfully, Jerolah had an ally in Tamoreh, the frizzy redhead whose dresses kept having to be pulled down, although nobody particularly wanted this to be the case: neither bystanders of her tree—trunks, nor the perpetually embarrassed creature herself. Tamoreh's frocks may have outlived their welcome an abundance of beers ago, but she could defend the educational system with unparalleled vigor. \"Sal!\", she exclaimed, \"why, it's the easiest thing in the world, once you're following the Manual!\" And out of her bosom she plucked the tiny booklet, its blue suede bedazzled with rhinestones. \"The Teacher's Way!\", it spelled out with enthusiasm. Jerolah took this as the signal to get his own extravagantly gilded copy out. Triumphantly he showed old Sal the frontispiece, in which he was depicted as a muscly angel with little to no chest hair. `,
` The meerkat disappeared, to Pauline's consternation, into the second hole. The first tunnel would have been a much safer choice: it veiled nothing less winsome than daffodils. For the part of the third, only french fries remained, though there had at twelve—thirty been laid out a formidable feast. But the second concealed that most fearsome of individuals: a lonesome, gawky character out of place and seeking, without much confidence, help.<br>\
 \"Do you come here often?\", whispered Marie. (A large sash wreathed her shoulders, revealing thus her name to one and all.) There was a pleading look in her eye which suggested a desperate need for relief of the urinary tract under circumstances where such a thing was impossible, for obscure political reasons.<br>\
 The meerkat peered at Marie with haughty reserve. Once he would have shrunk back at such cruelty, but lost souls seemed to linger at every corner, and he did not himself want to wear a sash and a permanent, yearning look of sadness.<br>\
 Just then a vine slithered into presence by the exit, a vine `,
` Once upon a time there lived a mouse with the malformed heart of a lion, for hereditary reasons best left unknown. It lived, at the time our story begins, in a lovely large house full of light due to its many large windows. This domain was larger than many a place our mouse had once known. But this domain, like all the others, did not belong to the little mouse. Quite rapidly the mouse, whose fur was very soft and white, picked up its common pastimes of being lonesome and being bored.<br>\
 Having these states of being for pastimes, and frequent ones at that, is extremely difficult. Sustaining loneliness is quite impossible for monkeys, as they live and die by one another; and humans are much the same. To tolerate extremes of solitude, they must have some activity which distracts them from their pain, and perhaps even provides sustenance. For our little white mouse this was the reading of books.<br>\
 Our eccentric rodent would turn pages much like some of its kind chowed down on cheese. It read of pirates, and dragons, and mages, and inventors, and princes, and fairy queens. All kinds of illustrious persons it got acquainted with, at a papery remove, and all kinds of fantastical creatures it discovered of and yearned to meet.<br>\
 Who am I to say what is right or wrong? But time passed, and our mouse's fur grew less soft, and one day it realized that it was growing quite old. `,
` \"At any rate, I have to be here,\" said Official Butt—Monkey Joel. He did, indeed, have to be there if he wished to gather his hourly salary of two dusty doubloons (pilfered from Shawn's grandmother's boudoir, of course; or, to be more specific, from the panel underneath her makeup—chest. In spite, or perhaps because of, her advanced age, Lady Cynthia enjoyed utilizing rouge and lead powder to reinvigorate the contrasts of tonality which her young face had permitted to be seen.<br>\
 Senior Charlatan Bigron grinned, allowing his gold molar (left) the benign influence of sunlight. He was looking forward to next week's duo performance of \"Signor Bottomfeeder's Bruise,\" a mildly out—there song by one of `,
` The tall but not especially handsome Englishman complimented the elderly host of the grenade—launching event in order to defuse the tension. He then baptized the audience into an enjoyment of his foreign songs, which, although not ranging far in terms of content, given the fixation on heartbeats and beds — still they were conducive to captivation and an increased observation of Squibs and Catherine—Wheels alike.<br>\
 An individual called Avery arrived next, dancing with gradual changes of tempo as green and white exploded safely far away from his face. It was then, amidst a shower of white, that the Crabnaugh came. \"Still your feet, you dithering idiot!\", he protested `,
` The mosquitoes formed a veritable plague against rational thought. Their presence itself was an affront to Reason, for whoever had heard of mosquitoes under an Inuit sky? But tonight it began, the end of times, when anything could happen. Anything undesirable, of course; nothing along the lines of Sedna losing forty pounds and becoming the smiling beauty he had known prior to the generation of Simba, Kim Junior, and Mo; of seals falling fat and numerous from the sky, if handily avoiding the roof of their sturdy grey abode, and of their neighbours; of himself receiving at last a Message from his ancestors.<br>\
 From his youth Kim had appeared singled out for some spiritual calling. Though tall, unusually so, especially considering his Pa and mother — there had been cruel jokes about a mailman, or perhaps the tall village fool, Shoue, having been taken for a lover — still he had not been athletic, and the height along with his pale solemnity had made him stick out like lichen in the mud. The elders, at first, had remarked how like a Tall One he was, and warned the villagers to be wary, lest this be an evil spirit come their way. Neither Pa nor mother had liked any of this much, but all the fight seemed to have gone out of them after the strange birth. There were whispers that the odd son only kept them around for food. `,
` The grey—haired woman stared piercingly at no—one in particular, or so it seemed; she was directing her stare at a very specific region in the fire. Any moment now Javunculus was scheduled to appear, bringing along to the fore of the flames a drove of minions. The bungalow's resident feline, a sleek black tom, made his way to the grate as if in anticipation. Perhaps one other such ritual calling had led, in some indirect way, to his being served an improved luncheon. <br>\
 In a far—off state, in a castle surrounded by glowing orbs like resplendent moons, Javunculus was busy scowling at his daughter, his monthly appointment with his erstwhile mentor nearly forgotten. Who could carry out such weightless obligations, flim—flam as all courtesy, when one's heir was revealed to have been stoking his political opposition's hopes? Javunculus would have had Jacelinda by the throat had his genteel butler, Ravison, not been present. As it was his scowl alone had to bear the threat of homicide.<br>\
 Jacelina, her confidence and vitality advertising themselves undeservedly through her delightful golden hair, tossed her braid over her shoulder. To Javunculus' horror, she hit his loyal Eavesdropper, Rémi, who'd been flitting about like an airborne rabbit. `,
` His beard was long and thick, a wiry cloud; a war trophy from a sheep which had been merely seeking to graze. Norberta, his grand—daughter, wondered whether it could be a dear place of repose for the daisies she had ransacked from the parking lot by the car repair shop. The baleful gaze that met her eyes when she raised them from her bouquet gave her a sudden shock, as though he were trickling his disapproval at her idea into her skull. Norberta, an adaptable little girl, if nothing else, changed tack by beginning the labor of a daisy chain.<br>\
 Her grandfather was increasingly remote of late, and she could not for the life of her understand why. Her mother, upon questioning, had succumbed to saying little more than \"it's that time of the year for him, dear.\" (It would never have occurred to Norberta to open comparable enquiries with her father, a remote figure in the sterile office on the second floor.) But what made times hard, then? And how could they in turn grow soft? As Norberta walked to school the next day she wondered whether snow and icicles could play into soft and hard simultaneously, and, if so, what would be the result. Slush? `,
` \"I fear my seeds won't find fertile soul,\" whispered the Essence of Babadook to the cloaked stranger.  The cloaked stranger nodded slightly, slowly, the gesture doing nothing to relieve its visage of the profound shadow which enclosed it in anonymity. The cloaked stranger, at six foot eight, could have borne some near—equine deformity, or else sought to conceal a too—beautiful aristocratic trait. (For it had been a long time since the people of that land had seen rulers, and so their conception of inherited heads of power rested largely with the handsome actors who embodied them upon the stage. It was a long time indeed since newspapers had sneered throughout every decade, whether to decry her as \"plain,\" \"frumpy,\" \"stout,\" or \"unable to be improved even by diamonds and lace\" (this on a wedding day), at the Queen Iboria. <br>\
 But as the cloaked stranger bathed further in its silence, the Essence of Babadook decided to rake some coals. It was suddenly aware of a glint amongst the embers; curious to see whether it had spotted, in a great stroke of luck, one of the Hanga—Léti Stones. <br>\
 Many years ago, newspapermen had salivated over the gruesome tale of murder extracted from these very halls; this very fireplace. Gémina Hanga—Léti had been little more than bones by the time her very thorough husband had rid of flesh, and even there he had intruded into some of the marrow. The many gems with which she had post—maidenhood cluttered her person, however, had not been intercepted as easily as her mortal remains. `,
` Strangely silent, the Chicken Mother peered disapprovingly at her offspring from over the remnants of her vegan omelette. The table, finely laden, bore as many as five varieties of loaves, in spite of the Chicken—Mother's recent well—meaning attempts to spare the household some expense by limiting the spread of bread to a mere ten pieces, garnished (as usual) with cheese. `,
` \"Mademoiselle!\", the pelican called out, with heart—rending earnestness, \"you have dropped thine handkerchief!\" Sure enough, he held that little square of pure white linen embroidered, in silk, with initials H.S. and a sheaf of wheat. (Highley Susspekt came from a lineage of gallants whose fortunes had come from the good luck of one geneticist, Albrecht Schürer, whose strain of wheat resistant to locusts had been just the ticket for Egypt during their great Plague of 1803.) He clutched it tightly with his left wingtip, an astonishing feat, yet this grip proved futile in the face of a mighty incoming gust of wind.<br>\
 Highley was already distracted, having been impelled by the sight of an empty bench into languorous daydreams about her former zebra companion, Hochsehrschön. Hochsehrschön, the descendant of a distinguished tutor to King Ferdinand the Second, had always been so solicitous of her comfort, ever willing to please by ensuring receipt of large quantities of macaroons for her well—populated tea—parties. (Though the tasties would be present at these occasions chiefly for her. As the Duchess Yukanna Tell remarked in her diary of 1931, \"how we all long for the sight of even a single Pineapple Nectarine at one of dear Highley's delightful High Teas. We discussed the matter when she left to tend to sweet Gerald\" — our heroine's temperamental poodle—\" and are in perfect accord to share such a specimen, should it arrive, equally.\" They were forty—three, counting the Wollsey Bishop. `,
` The vogue for parrots was nearly over in the godforsaken town of Gwendolen's Agreement. People were growing quite tired of having remarks, whether innocent or foul, repeated with a sprinkling of squawks. Mayor Pine Stanfly was at the forefront of this changing of the guard, having shot his own parrot in the forehead after having realized the source of that enigmatic new expression, \"Give it to me harder, Doug!\"<br>\
 But little Penelope Stirhope didn't want for such a dreadful change to occur. These importuning birds she had found the only source of light and laughter for some time in a very lonesome town. Not that anybody knew, of course! for whenever cursing escaped a parent, schoolmate, neighbour, in response to some fine piece of avian tomfoolery, little Penelope's face remained very solemn and still. Her schoolmates probably considered her to harbour even deeper parrot antipathies than they did themselves. Yet, in secret, in the blessed comfort of her comforters, Penelope would write at great length of the parrots' perfidious conduct, and of the various ways their victims expressed ire and rage, and she would laugh and laugh. But even her laughs were nigh impossible to notice, for she desperately wanted that no—one should hear. `,
` The lush foliage, pawed at, spread—eagled, revealed an aging leather rucksack in its midst. Cheery blue mosses had snaked their way over the soft brown surface, but Sadler reckoned they weren't, as he put it to his travel companion, \"cold—blooded killers.\" Having grown tired amidst the perfections of his manse and life, the heir to Sadler Silicate had spent the entirety of his adult life thus far hopping from one sinister obsession to another; this past week, like the past months and even year, had been dedicated to `,
` The three initials, entwined with such inventive boldness… Was this not the famous mark of Geraint Hohenhoch Azler, last silversmith to the Tzar? Struggling to conceal his eagerness, Mr. Tettenburn returned the clasp to its previous closed position and strung the (fairly innocuous) necklace back over the gold—coloured hand.<br>\
 Really Mr. Tettenburn had no especial interest in the work of Geraint Hohenhoch; nor was the necklace in question particularly to his taste, whether as a discreet manly chain for his own neck or as a present to entice oneself into a young lady's boudoir. (Mr. Tettenburn, although he rubbed rum on his hair—sparse scalp daily, to prevent balding, had long ago accepted that even his days of voluminous curls and full beard had not succeeded in endearing him to women the way money could.) Young ladies, he thought, always looked nicer with a variety of small gems upon their breasts being lit up by candlelight. Oh, that naughty Mr. Tettenburn! Let us liberate ourselves from his sad frolics at the Detter's second—hand shop and instead lend a visit to his wife.<br>\
 Mrs. Tettenburn was stirring sugar cubes, brown, into her hot black tea. The drowning, the dissolution of these perfectly angular forms was absorbing her totally. This was no coincidence, for Mrs. Tettenburn daily sought opportunities to perform such self—hypnotism, and allow herself to elude various regrets and self—recriminations. But today was slightly different. For in Mrs. Tettenburn's cup was a fish, native to the geysers of Olorado, which called itself Paul.<br>\
 Sylvia — for such had been her name, once — could never have dreamed of finding herself alone in the presence of a wishing—fish. It was perfectly counter to her morals. `,
` Everyone's enthusiasm for the boat outing was dampened by the fact that the mosquitoes had not yet limped off to mourn the sad remnants of summer. Nevertheless, they would not by such obvious bloodsuckers be dissuaded from enjoying the first stirrings of autumn; and so they embarked the Plaisaunce, Count Otterburn at the helm, the Duchess Grizhelda still a conspicuous adjuvant to the romance of her cousin Tomaso with the sly Mignonette.<br>\
 Why she was doing this Tomaso would likely never know. He was a foolish dreamer, who had previously directed too much energy into managing the repair of his departed father's, to put it delicately, hock. Although I have been told recently of more advantageous, temperate ways of paying off one's loans, Tomaso was bull—headed about paying the recently diseased Giuseppe's in full. There was something of the spirit of vengeance in this: the satisfaction of the son in demonstrating a fiscal prudence the father never could. But, more to our point, Tomaso's long days of solemn miserliness had much deprived his liver of that all—important nutrient for men of his youth. And so, Mignonette, an amie de coeur of Grizhelda's with less than perfect repute, had made him express rather sinister sentiments in his desire to remain aloof. `,
` Once the owl had hooted three times into its stew it was back to business. \"You must give me much more than these three measly onyx pebbles if you desire my services as food—chanter,\" it warned Egregio, turning its head the full 360 degrees for effect. Its yellow eye cast a pall of fear over the stalwart patrician's heart, and to his great surprise Egregio began to consider the efforts required in fleeing his sovereign without leaving behind any footprints. His Imperial Majesty Gotstool the Sixth had been unequivocal: it was of the utmost importance that the Elderly Owl be swayed to their cause. The Ropafangal dynasty had had no food—chanter in its employ since the Gustatory Reforms of 1918, and its numbers had greatly suffered for it. `,
` It was that fateful hour of three in the morning when the bells began to toll, rousing Sanskrit from his slumber and towards the dark alcove in which the Seminarians usually gathered to pray at times when the Basilica itself was not open.<br>\
 Usually Sanskrit would occupy his feeble mind with limited wonderings about the approaching first breakfast's composition — and, if he was `,
` Seratonga threw a bottle of nail polish into the bucket for good measure, hoping this relic from the Times of America would provide a satisfactory touch of the antique for her commissioner. He was the kind of man who had a great thirst to understand feminine urges for adornment, and analyzing those of the women of the past allowed him to sidestep his woe at his neglect by the women of today — Seratonga excluded, of course, because Seratonga knew how to make a sale.<br>\
 She had been taught when she was eleven and the second day of selling chocolates had left her with half a box of bars, melting. Seratonga's state of despair was such as can only be reached by disappointment commingled with hunger and physical fatigue — for she had crossed perhaps half the town, in her search for clients: gone past even the Powerline Bridge. Let alone her fear that the curling chocolates might never tempt customers again, and result in expense on her end! `,
` \"Should we take off, Captain?\", Oblivius inquired. He was a solemn, self—serious lad who had been described by his father, in an odd moment of levity, as a dog amongst cats. In either case there were no cats at all aboard the Squingee, none at all, only fifty men tired of crackers and salted fish. And one who had a secret stash of chocolate concealed within the ornate globes on his bureau.<br>\
 The Captain, taken aback by Oblivius' intrusion and hoping there wasn't any trace of cocoa on his face, raised a sole, significant eyebrow. His mode of operation with the crew members was to act perfectly imperturbable until six pm on Sundays, at which point he would invite everybody onto the poop deck to toast his (parrot—shaped) tankard of gin. It was as of now merely Tuesday, and therefore his code of conduct required the semblance of indifference. As it happened, he had resorted to rather more chocolate pellets than intended as he'd mulled over the best time to leave Palaïca, earlier. In the end he'd made no decision at all. It was quite embarrassing, really, and some lie would be necessary that he might be let quite alone.<br>\
 \"This old log of Pirate Hornbridge,\" said the Captain `,
` The thicket was pungent with the smell of mangoes. Pell—Mell's eyes gleamed with delight. As the sun set further, and far up above the lush growth clouds blazed with the colours of grapefruit, the wood—creature's eyes grew only more prominent. By the time it was dusk two green orbs floated in the darkness, waiting. No more.<br>\
 Ftatateeta came at the promised hour, clad in purple silks and rich blue velvet, bearing the bronze jug in front of her as if it were a crucifix, and the world a series of vampires. Two eyes blinked at her appearance, and stayed in place until she was gone. There was a package at Their feet now, too, bearing raisins and strawberry. `,
` The soft snores of the Purple Dragon softened Hegemon's heart. That proud creature, in the throes of slumber, bore a tender smile that betokened nobility of spirit. This smile chiefly abstaining from the Dragon's presences at court `,
` Sizler puffed again at his pipe. None of the men seated around him under the old oak tree so generous with its shade in this day of Indian summer — none of those men seemed particularly eager to hear the rest of what he had to say, once again from the pipe he should take a break.  But that was the way of things, in the old Dutch village of —, under the low greenish light filtering in from the leaves. There men looked half—asleep when they were most intent, possibly because thought took so much effort.<br>\
 Sizler coughed a dry little pretense and looked around mildly. \"I used to see old Miller Deeg's daughter hiding behind the mills, I did. Don’t know why she trained around there. Dogs seemed to bark more often in those times I spotted her about, and I couldn't tell you why, seeing as nobody about there had dogs on account of the Millers' Cats.\"<br>\
 The Millers' Cats was a loosely named congregation of strays that had adopted the mill complex for their playground. So far the mill complex hadn't complained, although its neighbours had. `,
` The bells had rung their solemn warning, yet Yannick the hedgehog remained unrepentantly committed to being late. This glittering party at which he was eagerly awaited by the local bishop and the fifty youngest nuns of his estate — why, he would have turned down the invitation outright, were that not beyond his powers to handle. For such a move would have had Yannick in untold agonies as he wondered whether the bishop and his fifty young beauties would hate him, or guess that he was being duplicitous (in his undoubted excuses); or both. <br>\
 Yannick had not always mingled with such exalted circles as those of Bishop Suzein. His uncle, Giarnimo the Just, was a mere frog, although one much renowned in his corner of the pond for his fairness in arbitrage disputes over water beetles, cicadas, and  `,
` The hole in the sock determined the demise of the latter. Mrs. Stevensie may have been intent as a piece of pie on saving pennies, but there was no way she would stoop so low as to learn to sow. A steady diet of darning socks, Mrs. Stevensie suspected, was the surest way to darnation. She preferred to keep her tongue in motion and her lovely hands idle. <br>\
 \"Fish,\" she called out,  ringing the first—floor bell for good measure, \"the tea, please.\" Indeed Mrs. Stevensie's afternoon tea had already suffered a delay of more than thirty minutes, though she was too precious to let the servants know she was displeased with lateness. Yet she had subtle ways of provoking one, in retaliation, later, and so it was with growing apprehension that Fishel Tson cut the crusts off his little bread—and—butter domes and took the clotted cream out of the oven. `,
` \"Must one always grow obsessed, that she should learn something?\", Wichtiger sighed. The female pronoun was both a nod to the current convention that Womankind needed more time under the linguistic sun and a convenient subterfuge. Wichtiger was as given to obsession as a gambling rat.<br>\
 Previously this aspect of his personality had caused him both untold ecstasies and unparalleled bouts of suffering. He had decided, with the support of numerous humourless books as well as his staid and judgemental family, that something at the very core of him was rotten — or perhaps that in the apple of him hid a worm.<br>\
 And yet now that he had encountered Lebenswilde, Wichtiger was beginning to nurture notions that men are as various plants, each in need of his proper temperature and climate, each in search of tender gardeners. For he felt that the little behatted mouse brought him calm and joy at their every excursion into the Mouse Caves. Moreover, his rodent companion's keen interest in drapery justified and informed his own, hitherto neglected and consequently malformed. `,
` The dark cloud threatened to overwhelm the remnant of pale, dusking orange sky. Grimhom frowned, having tasted the dust in the air and thought of antelopes. An ill wind was blowing, which presaged ill. Grimhom couldn't help but think back to the days he would wait, immobile in the woods of the mountain, waiting for the Great Tits to come. Seed in hand. Now no seed in the world could entice the yellow—bellied birds to his palm, and the trees also were gone.<br>\
 The antelopes had started coming when Grimhom was thirteen, maybe; roughly about the time of the copper—working apprenticeship that had never materialized. Old Krisham had fallen too ill, his eyes too rheumy; and his successor Dashin's eyes had wondered excessively to the moon, nimble as his pudgy fingers had been. He had kindly invited Grimhom's father over for a bite to eat, and the widower had arrived, white—bearded, children walking by him, into that little kitchen with walls the color of lapis lazuli. Sitting down to grapes and goat cheese he had been taken aback by the first mention of curses, the references to ghost—seeing. Yes, Dashin had spent far too long gazing at the moon; Grimhom's father had been quite clear in his coward's at—home mocking. `,
` The light of the setting sun in such a fashion as to make a thin bottom section of the giant cloud look like lace, or gossamer. Silvin looked towards  the distant mountain the whole other way from any hint of gossamer: sighed.<br>\
 Ever since the Walnut Fairy had come to the orchard had been reminded `,
` The tall gentle bearded creature hugged Izzamakizzal. Tightly; began stroking her back. \"You are brave and strong,\" it said, or perhaps it called her something other than strong. Afterwards Izzamakizzal couldn't remember the short but carefully selected list of adjectives, much as she wished she could. She remember for sure that it had called her intelligent, and that it'd said she was not alone. And then it was gone, in a mist smelling of pinecones, and she was left looking at an erstwhile raspberry bush that November had covered with frost.<br>\
 Izzamakizzal's twenty—third head, the one which tended to keep out of sight because of its indecent location, began to ululate loudly. `,
` \"Salute!\", screeched Admiral Hussar. Lieutenant Nimtin was passing by Hussar's squadron, his chest puffed out even more than usual, the purple colour of his silk cravat foreboding ill (for purple, the colour of royalty, he wore on days he felt particularly regal) — and the very sight of the Lieutenant was inducing in Hussar cold sweats, because all the men In his squadron were at that time decked in women's bloomers. And soon enough the Admiral would lend that notice.<br>\
 \"Sean?\", he asked, slowly. With his long index finger, which bore an abhorrently large emerald, he kept seizing at his pert goatee. It was really quite unnerving, but Hussar — whose first name was indeed, as the admiral recalled from their naval academy days, Sean — couldn't bring himself to look away. Or to answer.<br>\
 \"Sean,\" the Admiral repeated impatiently. His fingers were now performing a silent tap—dance on his chin. To Lieutenant Sean Hussar's overwhelming relief he was interrupted by the arrival of the Andromeda's very own fish—porter, an Irishman sporting a yellow hat and the first name Jim. `,
` Hattie the Hyena paced about the small lunching cave scattered with bones. \"I want to be independent, Harold,\" she hissed. \"I'm sick of eating the lions' remnants. I can't tell anymore whether I like Ligon on her own merits or because she gives me bits for my stew.\" She gave Harold, who was cheerily slurping at his bowl, a withering glance, sneezed, then frowned, slumping her shoulders. \"I have no respect left for myself.\"<br>\
 Just then Seedin the Sage burrowed out from the ground, the speed of his exit causing the femurs, ribs and tibias he'd displaced to shoot jauntily up into the air. He pulled this sort of trick about once every three Tuesdays; the hyenas tolerated his visits because he was funny enough and, more importantly, tended to turn the bones he'd scattered into strips of bacon. <br>\
 \"Why milady, if you don't respect yourself, why are your dark patches so deliciously rotund?\", Seedin asked, adjusting his weather—beaten leather cowboy hat's brim. (Prior to his shift to Spirituality and Magick, Seedin had run a farm and enjoyed saying \"Howdy, partner\" to passing gentlemen as he tipped this very brim.) `,
` Sardinian's self—interest was piqued by the mention of exotic wenches, for he was a great connoisseur of female buttocks and haunches, delighting in distinguishing the differences from race to race. Why, it was almost of as much interest to him as the construction of his new Italianate villa by Simon de Beauvoir! Sardinian leaned closer to the stranger with the wonderfully manicured beard — why, it reminded him of those delightful animal topiaries that were all the rage in France right now; in it he could almost see a duck! — and raised a finger ornate with lapis lazuli to his own bare chin. His face remained impassive, but the sign was clear to any self—respecting merchant. To further confound any possible listeners, the response of the bearded one was to take out a deck of cards. \"Blackjack?\", he inquired mildly. But the four cards he laid out first clearly spelled the date, and the next set the time.<br>\
 Sardinian frowned. His aunt Bethilda would be visiting at that stage of November, and having become in her widowhood an ostentatious zealot the woman would stick to his side the whole fortnight, keeping him from sin with her watchful eagle's eye, as she called it. `,
` Jennir looked in the streaky mirror at his new cowslip. This one had installed itself, quite audaciously, by the birthmark on the side of his nose, as if it were more fertile soil than the rest. Perhaps indeed it had been rewarded for its choice, for for a cowslip it was vast. If only his seller, Guantanamara, could find a market for such sprigs! It was easy to sell, say, his orchids, or dusky roses; but much as he liked cowslips and hickory, they were not \"en vogue.\" <br>\
 Yesterday, over a pint of camomile at The Tea Party, he had made moan of this mercantile problem to his longtime friend Steve. Steve had nodded along quietly, gazing intently at him all the while. Such was this intensity that Jennir wondered — not for the first time — whether Steve was, in fact, in love with him. Not having known the kind of passionate caring evinced by Steve outside of liaisons with pretty maidens, it is not surprising that he should have thought so.<br>\
 Then the words had come from the sage. \"With all love and respect,\" Steve had said, \"you have only ever been a dabbler both in flowers and in sales. You make plans neither to regulate your florals, nor to integrate the existing market.\" His voice had been very gentle as he said this, but Jennir knew he was being condescended to. `,
` The cry of the cuckoo had been ominous. Turkey vultures had been gliding, barely flapping all about. It was an unseemly October, early to lay bare its branches, late to resign its heated afternoons. And now there was the head of Charlie Boone, its bright green eyes pecked out, to contend with, too. <br>\
 Ligendorf had not expected that particular delivery to be hidden amongst the typical cabbages in his Sunday basket. But he was, mercifully, able to keep his cool. He had re—entered his condo rental and gotten as far as the upstairs bathroom before dumping the head into the bathtub and running for the bleach. `,
` \"The focus of your education this year,\" began Professor Wingschermer, attempting with much effort of will to suppress the encroaching sneeze, \"shall be mastering `,
` Alas the pineapple tree was not destined to bear any further fruit! Its first glory had been seized by the excitement of the lightning storm of '83, that thrilling time when the Queen had been visiting and university students accustomed to, and excited by, histrionics had put on a Prairie show. \"The Pile o' Bones,\" it was, for as such had Saskatchewan formerly been known `,
` The heat to conquer had evaporated with the arrival of one woman who seemed to know what it was to wield authority over very young beavers. She neither simpered, quailed, nor shut down before one such glossy individual evidently ready to decimate her Cladrastis lounge—chair imported, along with a pint or twelve of whiskey, for her father, from Tennessee. She did not bow down and assume a voice of falsified naïveté, laugh with fraudulent hilarity at his slightest attempts at pratfalls. She merely observed coolly and then said: \"I've dealt with your ilk before, junior, having played nursemaid to a litter of five kits, all with their incisors ee—rupted. We'll have none of that too—nayt, young'un, and ye'll hurry behind yer mama down the alley line.\"<br>\
 Jerha, for that was her name, had had the good fortune to be born strong. It certainly hadn't been the good fortune to be born lucky, because she'd been the sixth of seven and had the dubious pleasure of witnessing both mother and youngest trampled to death by stampeding quails. Why, after that it had been suggested to Jerha strongly, and swiftly, that nobody much liked hearing constant wails and cries, and mightn't a fresh—faced young chit like herself prefer repurposing such screams to the worship of Our Lord, at the Nunnery of Agnes St—Thells?<br>\
 Agnes herself hadn't been associated with Thells in any way until she turned eight and the Horned Hashtobinths came to her hometown of St—Prale, a timid little place divvied into peach orchards and steel mill territory. `,
` The woman's eyes blazed; her calm demeanour had been discarded like a flimsy veil. \"How could you have failed at so simple a task, you nitwit? I ask you to bring back Flies of Samarkand and you return with a mere Breeding—ground of Fleas!\" Her lips twisted in disgust, and soon the Countess of Brabant left Massimo tangible proof of her discontent: upon his cheek a red buckle—mark. <br>\
 The Countess was notorious in Megoria for her belt—fondness. She was known, when out and about, to initiate trades with strangers whose belts appeared of superior make, or exceptional material, or outstanding softness. Some papers had published caricatures of her engaged in unseemly activity with belts twined around her like languorous snakes, or vines. But chiefly, though few knew it, the belts were around in such quantities because once a belt had been stained with blood, its prospects were over. `,
` The carpet, though threadbare today, had evidently once presented as a shimmering marvel of the finest Phoenician handiwork. Alas! its present owner had been reckless, negligent even: the beauteous images of men riding horseback, of damsels frolicking in the fields, of mischievous naked cherubs whispering to one another and preparing to dispatch arrows — all of these were now incomplete, their threads having been buffeted by all manner of incidents: contact with smoke, spears, children's scissors… But the state of the rug was really no concern of Zufrieda's. She turned her attention back to Lord Dunstevvy and his swollen, ring—heavy fingers. <br>\
 \"The tree will have to be cut, there is simply no other way we could do it,\" he said wearily, resting his left cheek on the corresponding fingers. Zufrieda watched the doughy flesh sink, flinched; crevassed. It was horrifyingly fascinating. She herself was an aesthete with a strict preference for the opposite of fatness. But the imminent end of the poplar tree demanded her attention in a way the earlier mention of the burning of pixies in Town A—— never could have.<br>\
 \"My Lord,\" she sputtered, blanching, \"that's the tree r
 ound which is built my grandmother's house!\" `,
` The monkey unabashedly continued grabbing handfuls of grapevine to stuff into its pockets. Its hands were sticky with red juice, but the pockets of the adventure—suit Monsieur Zouzon had prepared for him were very many, and it was not willing to cease its activity until the very maximum amount of grapes possible had been concealed.<br>\
 Soon enough a voice interrupted the monkey's happy yattering, the echo of it amongst the caverns and lomba trees sending the monkey scampering away from the vines. \"Santiago!,\" it boomed, \"Santiago!\" Many small leaves and dark purple globules of fruit escaped Santiago's adventure—suit as he sought refuge, concealment, but he was beyond any pleasures of sweetness now. He was thinking of his time with Master in the Canyon.<br>\
 Master had brought him to the Canyon three years ago, wrapped in palm leaves and anxiously cradling three bananas — a parting gift pooled by the other monkeys, those remaining in Mr. Twiddley's Exotic Zoo. Those who had remained duly suspicious of the woman in pink who had visited their enclosure with secret sweets and a secret smile each Tuesday afternoon. `,
` It had been determined by the doctors that the Mother was dead. At this revelation Bannerjee took a swig from his hip flask, the one with elephants and ibexes and sacred cows carved out of ivory, and Nathaniel said nothing at all, wondering whether Mother's eyes were open or closed; whether she had died sad or happy, and whether she would go to Heaven.<br>\
 It had always puzzled Nathaniel, that smiles were said to be the gift of Heaven. Frowns and mess, probably, encountered a bouncer at the Pearly Gates: a fierce brute who could nonetheless sit quietly and admit honor to defeat. Heaven's Mess—Bouncer already seemed so real to Nathaniel that `,
` The cavern walls glowed with large crystals of pastel hues. Tercina's egg—like throne appeared to have been carved from one giant opal. Bovirt was taken aback by this abundance of beauty, did not like the lulling effect of all this quiet splendour. Fighting a losing battle, he wondered how many slaves were in Tercina's employ, or perhaps how many had contributed throughout the years to her inheritance.<br>\
 Tercina raised her eyebrows at the long silence, gave Bovirt an indulgent smile through half—lidded eyes. \"You expected all this bounty not, little cowherd? But it was no little milkmaid you saved. Fair is fair: name your favor, and you shall have your payment.\" <br>\
 This new offer paralyzed the cowherd with fear. There was nothing he wanted particularly right now, save for a cottage he could call his own; and yet that would be no mean feat, to achieve such a goal, and he could not imagine giving up its pursuit to a wave of Tercina's wand.<br>\
 \"I don't carry wands around anymore; they age one dreadfully, you know.\" remarked Tercina with mock concern. Bovirt blushed, realizing that he was, and must have been, absentmindedly waving his left hand in some subconscious cleansing gesture. The only thing he could think to use a wish for was purity of soul, but out of consideration for the charged political climate `,
` The phoenix's tail looked ragged; Olly had no better word for it. Its plumes were mangled `,
` Girenetta looked at her dressing—room table, an ornate slip of a thing typically besieged with flowers, letters reeking of cologne, and even the odd bejewelled lorgnette. Today, to her surprise, there was but one envelope, sadly lacking the seal which would have indicated her would—be lover was of the nobility. Still — being alone as it was, it would have warranted a fine sum for her maidservant, Arietty, who was quite content, while the sun of her mistress' fame shone for  a few seasons more, to make hay. She had a babe at home, after all, and a husband who was a painter. <br>\
 Privately Girenetta wondered what it was that pretty, clever women ever did see in painters and their ilk. Not that she was above a portrait, for publicity — but a love affair would be entirely out of the question. She, too, was in a line of work that required daily seduction, and knew that in a dance of two only one could ever play that game. Whatever his society connections, there was no interest in being wooed by a penniless fanatic of Art, and to be the seductress of one of that damned breed would signal the end of her time on the Earth. Of the stage, of course. To be lowered thus, to the vile status of desirer; cover with heavy mantle those shoulders, those arms bare and meant to solicit longing. One had to remain untouchable to survive any transformation. `,
` Hero the Hedgehog had just unwittingly ingested an absurd amount of arsenic. But she was fine, and would survive unscathed. Her resistance to a range of poisons was as much part of her as her louche nighttime strolls of five—hundred meters to three kilometers (she kept careful track of the distances she traversed with the collaboration of Humphrey the Human, a rather eccentric researcher) and her fierce need for independence, or her adeptness at climbing. That is to say, she took it for granted, because it was constitutional.<br>\
 But one thing Hero the Hedgehog did not take for granted: exploration. Between her hunts and the rigours of a vigorous sleep schedule, she often found herself settling into a stultifying routine. How she longed to go further south, and to hear at last the river which trailed in a thin silver thread at the foot of the Coxhills! She sighed. For soon it would be April, she could feel it, and her concerns would be diverted into the great communal need to be of Nature's party, and reproduce. Not that it was not jolly good fun, in its own way, with its keen yearnings and extended rough—housings — once the far—travelling fellows had fought for your paw, and patiently endured your inspection, and obtained that supreme felicity of sexual access. `,
` The pilgrimage was once again interrupted by chaos, in the form of long—bells. Leticia frowned, peering at the red—suited musicians as best she could through the mist. Their metonymic instruments were wonderfully ornate, carved with all manner of mythological mixes: manticores, gryphons, harpies, sirens. There were also merely exotic animals — lions, zebras, flamingoes and one elephant that took up an unwarranted amount of space, extending over not one but two instruments, revealing itself only when these bells were aligned in a row — as well as a handful of idiosyncratic favourites: a badger, a hedgehog, and a great deal of roe. She supposed this last feature was a universal reference to fish which managed to evade the inconvenience of actually carving any. Such reticence was easy to hypothesize on the basis of the extremely limited competence plain to see in the Siren's scales.<br>\
 But the long—bells had clearly come to impart some lesson, and Leticia's next memories are of sonorous clanging and of a little red—clad man emerging from the mist bearing not a bell, but parchment. `,
` \"Is he truly the gardener of the Wasabi Roots?\", Laverna asked with a cynical smile. His outfit suggested a total lack of proximity to dirt, particularly the dress—shirt so pure white `,
` The pineapple was huge, enormous. Madeline was grasping about for this word in German but only the initial r and the uncertain memory of an s and g resurfaced, and so she yawned, mouth naturally politely covered, her fatigue had made it inescapable. `,
` The frog hopped over to the tower with great melancholy in his spirit and soul. He had been severely thwarted in his attempt at light—hearted amusement with his friends the Fireflies of the Sword, an assortment of mammals and amphibians that enjoyed pretending to be, as their group name indicated, Fireflies with Swords — after, of course, having toasted to \"Freedooom!\" with variously sized tankards of ale. Alas! the frog had been interrupted, brutally chased before even he could taste the foam of his favoured Jungle Pale Ale — besieged, set upon by the wicked Malvina, Devourer of Frogs and Newts!<br>\
  Apparently Malvina had been a Great Beauty once, and driven around in style in an ornate Water—Carriage inlaid with Mother—of—Pearl and harnessed to twenty finely—pedigreed Lobsters. The frog had only cared about the Lobsters involved, to be perfectly honest. Weren't they only able to swim backwards? Surely they were not the best crustaceans for the job of transportation. Fish would have been better, a good shoal; he himself would have recommended seahorses. But Malvina had not paid any mind to the frog's disinterest: she had been intent on figuring out how to eat him. He had been very hard to get at; and, besides, she liked to have the cooking method and final dish figured out in advance. `,
` The coincidence was too staggering to admit, let alone behold. The worst of it, reflected Kent to himself, kicking bitterly at a stool, was that it all hinged around a shoe. Inconceivable!<br>\
 The shoe in question, a perfectly respectable white calfskin slipper, had been one of two upon young Cadswallop Junior's wee feet. The little lord had been kicking his feet jauntily, or perhaps half—heartedly, or else in protest at the fact that the various large dirty mustard—yellow or faded orange—peel construction vehicles in the middle of the road were not performing various manoeuvres to his great satisfaction. It was past the end of the workday, after all; it was even, all about the crunching of dry fallen leaves underfoot, like crustacean shells, dark. But Mrs. Pingleton, the wee lordling's nanny, could not report with any certainty what had been afoot. She had been too focused on panting, and running, in the direction of her friend Tom the Tomcat's patriarch's abode. The weight of the stroller, her hands steering the handlebar: these had been mere footnotes. When the little lordling was facing forwards in this his first carriage it was remarkably easy to avoid taking notice, and it was especially so when one was on the way to collaborate in making pie. `,
` The mosquito popped between Spero's fingers, and the calm young Squire ducked to avoid a spray of blood or anything to the effect of a rebuke. He didn't understand why himself, to be perfectly honest, but whenever he didn't get his way `,
` The dragon's yellow scales were tingling ominously with the threats of fights to come. Conucius, for that was his name, sighed both with sadness and relief. He didn't care much for bloodshed, but at least it wasn't his lone green scale bothering him. That would have presaged imminent death.<br>\
 Conucius' fortune—telling scales had been a gift to him from his favourite aunty twice removed, Sagra Lynn. Having lost first her left wing to a drunken bludgeoning by a desperate and scrawny ogre, and then her right to frostbite on one rapidly chilling night during a mountain—climbing expedition, Aunty Sagra had, astoundingly, never managed to give up hope. Hope of just what, exactly? Unclear to Conucius was his aunty's philosophy, but he did know undoubtedly that on his mother's fourtieth birthday, when he went outside of the Frothy Lagoon for a silent smoke, Sagra Lynn shuffled up to him and asked how he felt about cats. Later he realized that `,
` The harpsichord had been tuned so that its do was the appropriate frequency for baroque music originating from France. It was perfect, thought Pritchard, rubbing his hands together, for war. Messrs. John Trickham and Fard Stinkee had polluted for too long with their empty blandishments and tasteless, harried productions the hallowed auditorium of Ranna Hall. He was ready at last — morally, physically, and spiritually — to sabotage their upcoming production by any means possible. Step one was to ensure the instruments all sounded wrong. This, after all, was meant to be a successful performance of the Italian work of Haendel.<br>\
 Step two was the divesting of funds allocated for costumes. No—one would design splendid outfits destined to enchant — least of all the dame currently responsible for costumes, the incomparable (and incomparably well paid) Tina Aggeccio — if their salary had been gambled away. And Paul Ackerman, responsible for providing the hireling of Linkholm Opera with monthly envelopes, was easily persuaded into exchanging Tina Aggeccio's for the chance of a night of pleasure with a pretty redhead whose posture was oddly stiff. That Paul Ackerman overestimated his chance by practically one hundred percent was not something he could very well sue over. `,
` Within the spindly prickly sphere of the Ostaropp was concealed the most priceless treasure nobody had known. Some suspected it was a necklace: gold encrusted with rubies, large. Others claimed it was a tiara glittering with emerald, sapphires and topaz, and that it pulsed with an enchantment to make its wearer seem beautiful. Yet more intrepid adventurers had come up terribly close to the Ostaropp, close enough to hear the low penetrating whisper of foreign garbles emanating from within the enclosure. These brave souls, little affected by the foreign whispers, had perceived the enclosed glimmer with varying degrees of success. Ted, the eternal optimist, was just about certain that chessmen of diamond were the source of all this unruly talk. (For Ted, any talk he could not understand was unruly: a dog's, a teacher's, his wife's…) <br>\
 Ted had decided to confront the Ostaropp after his cousin Simpell claimed that had bitten his toes and scraped off \"more than the usual\" skin. \"Do you mean to say,\" Ted had asked, grimly, \"that you thought shoving your feet inside the Ostaropp was best?\"<br>\
 \"Only the left one,\" Simpel replied, peeling a lemon. `,
` Gurlick wiped the sweat from his brow and reminded himself of the words of his father, that figure in an advanced state of putrefaction due to increasingly chafing gold ankle bracelets and long—neglected diabetes, healthy tanned skin reduced to some sallow approximation of clay. \"Beware of the ensouled flesh, my boy,\" he had rasped; and the worst of it was, that Gurlick knew he had been sincere in uttering this gibberish, knew it from the pained vehemence in his voice as he continued with a second warning — \"The Devil's dues must be paid!\" — and collapsed, expired. Dead.<br>\
 The first dead thing — no, Gurlick did not remember the first dead thing, it could have been any of the creatures visible more so in the city than the country, proportionally at least: a rat, a pigeon, a moth; perhaps some squirrel cleverly chased out into the street. But Gurlick remembered very well the poster with two strange blue cats entwined in an aquarium. They had had empty eyes and clothes like people in the little fruit shop wore sometimes, when they walked in mostly large groups of red—lipped women and girls and smiled at him and Aunty. They were obviously not like the cats he knew, who they, too, were strange, in that they didn't drink milk like in the cartoons. Yet evidently their names were not Pussy or Fluffy, and he suspected that they could talk, too.<br>\
 It was a beautiful poster, disquieting in the way that made one want to see more, suspecting it hid an important piece of news. Gurlick would look at it long and hard whenever his friend Louise left the basement, interrupting their crude maps and make—believe searches for treasure in a search for new props, or a request for snacks from the mysterious grownups. For all he knew these as well could have included some secret ritual; `,
` They had just finished a lively reel, and private smiles as well as furtive shrugs were being exchanged while the announcer slicked back his hair (a pretense for the audience's benefit: he had gone bald at thirty, and his wig was as stiff as a board.) `,
` Thieldebaum, to Hossinder's great astonishment, successfully ripped the leather ribbon in two. A snarl transformed his face into an omen of retribution; he was the avenging angel turned loose at Armageddon. Or something like that. Neither of Hossinder's parents had pushed, nor even vaguely enticed, him to attend Sunday school. <br>\
 \"How dare you,\" Thieldebaum hissed. His face was frighteningly calm again, in contrast to the contiguously sinister tone of his susurrations. Perhaps most disconcertingly, he continued to pet his pet turtle Mo. Surely Mo couldn't feel the touches on his shell? But this was besides the point. Hossinder took a deep breath and began to speak, his eyes fixed on the portrait of Lady Wimbleding the Third above the armchair with the obsolete anti—macassar. \"I love riding horses, Thielly, and there's nothing and no—one that could stop me. I've held my true nature back for too long!\", he continued, and then continued some more, all in this passionate vein, insisting that he would have run them into three times the debt they were in now if he'd had to, if the price of dressage had been even more impacted by inflation than that of bread (a straightforward quadrupling, to the dismay of all yeast—reliant souls).  `,
` The pelicans were preoccupied with the continued missingness of the gold ring whose discovery had presaged such rich rewards. Anja, looking to the snow—capped mountains in the distance, wondered what it meant, to forsake a promise, when you were made of metal. She herself had the usual nuts and bolts; nothing inorganic dared penetrate her inner sanctum, but she had seen what happened `,
` Adelaide's finger gleamed with the odd glutinous green stuff. She suppressed the urge to fling it off and focused on it more closely, trying to see the rumoured tiny figures trapped within. Was that a hand, waggling tiny fingers? Unsure of herself, Adelaide looked away, turning her confused gaze back to Professor Schwarzkrieff. This man simply furrowed his mighty grey eyebrows and gestured at her to go on. <br>\
 The dinner gong rang unnoticed by these two focused little characters, although Madame Diptwahn passed by eventually, as quiet as a well—oiled seesaw, to leave a plate stacked high with miniscule sandwiches by the alembic.<br>\
 This roused Schwarzkrieff from his reverie. He gave the air a deep, intent sniff. \"Nut cutlet?\", he asked, his eyes going squinty. Madame Diptwahn's own lovely brown eyes went slightly larger than usual, making her look so ravishingly apologetic that even murder wouldn't have been so bad. But her voice was quite firm as she reminded Monsieur le Professeur that this was a vegetarian household, and would remain so, for as long as its Science program was maintained by the endowments from her venerable herbivorous ancestress, Lady Luzielle Diptwahn the Sixth.<br>\
 Adelaide had been excitedly noting the outline of a small pair of buttocks when she heard \"Luzielle\" and blinked. But that was `,
` Erkonik the Slug grimaced, in the discreet way of his kind, at the inscription. \"SEVEN P. FOR ENTRY LEAVE BAGS BEHIND VASE\" did not sound very friendly, especially as he was forty pence short of the required sum. He supposed that it was time to contact Suzy, his usual financier. The prospect was not a jolly one, and Erkonik was able to find humour even in the sight of former colleagues trod underfoot.<br>\
 Suzy did not kill you outright, but with each loan she wheedled something more out of you. Today it was lunch, tomorrow your participation in the hijacking of an oil rig. Erkonik shivered at the memory of the vast sea waters turning oily and bright green with the Bioluminescent Decoy Dye his fellow sufferer at Suzy's clutches, Bryce the Bee, had mixed into the terminal port. Not for the first time, he wondered how the sly sloth had gotten into her line of trade. Bryce had met her at a hatmaker's, where he'd been seeking a pageboy of the right size and consistency. Her booming voice had clashed most severely with the clever, understated advice she shared with first—time clients. `,
` The pelican eggs had cracked, Saundra realized — possibly all four of them! She shuddered with disgust as well as the disappointment that comes when, having tried to minimize the cost to one's wallet, one realizes that the thrifty attempt has caused its own inconvenience. `,
` The hag cackled at Serafina, the red hairs poking out of zits on her chin wiggling an accompaniment to her mirth. \"Why, it's been years since I had meself such a good giggle!\" She approached Tom, the old clown dummy perched atop her cedar chiffonier, and gave his red nose a good pinch. Reflexively Serafina covered her own nose, as well as a good amount of cheek. The hag's eyes obviously didn't need to be facing you for sight to enter the interaction, because it was at that moment `,
` The light—haired boy in the black anorak frowned and sighed, an overfed petulance his dominant demeanour in that dreary November. \"Why didn't you answer my letter? I'd tried so hard to make dragon—hunting look an enticing prospect!\" Bitterly he kicked one of the many waterlogged toys littering the shore. This almost awakened pity in his interlocutor, who as a young girl had found much comfort in precisely this plushie's image: in The Elephant Tom. But the many decades of life since then had hardened her; and, besides, her admiration and affection had never extended to the vague, flimflam sort of folk that populated her life beyond the TV screen. \"Dragon hunting is déclassé nowadays,\" said the Dowager Duchess in her quiet, deceptively passive way. \"It's been usurped by the sport of hunting husbands, which I'm `,
` The goats bleated plaintively, much to the satisfaction of the handful of society painters who had come to take a gander at capturing the likeness of animals. Illingsworth, for instance, having recently been savaged for his portrait of Lady Billig and her Puss — critics had suggested that “Puss” looked rather like a furry dinosaur, and debated which prehistoric era such a Puss came from —, Illingsworth, well, had come to this petting zoo aimed at children with a great deal to prove. Marlowe, for his part, was trying to stay away from gambling: chastity which belonged to a new seduction scheme. The tobacconist’s daughter came from rough straits, granted, but _was_ exceedingly young and pretty. Fortunately for Marlowe’s artistic reputation, such periods of romance increased his productivity tremendously; the disappointment which inevitably followed the seduction of his newest precious angel he could only assuage by acknowledging to the fullest that all was worthless, especially money, and life meaningless.<br>\
 Girvsy, setting up his easel, was surprised to find Marlowe on the prowl again so soon. As irksome as he found that weak spirit, he had to admit that the man was his only real competitor on the scene. `,
` “If you’re to be a Magician,” chuckled Nihiro at her miserable—looking sponge—crusher of a student, “you must forget about pretty much all of those layabouts you call friends!”<br>\
 The harsh words had the desired effect. Perilandra gave a little gasp, growing white with rage — which, given her usual state of pallor, meant that she now rivalled the moon. Nihiro pressed this advantage. “You know it full well — the acrobat desires an audience for her tricks, the pretty parlormaid is terrifyingly lonely, and the clown rightly fears that without females constantly milling about, the only things he shall have to stave off shall be indigestion and boredom. None of them are as single—minded as me — or you.” She hooked a finger at Perilandra and was about to whisper conspiratorially; this segment of the speech tended to be flattering and amusing. But there was an unexpected clacking, suddenly, as of many heavy beings enclosed in shells rolling merrily into a funnel; consequently Nihiro went to the turtle phone and picked up the receiver without a glance at her pupil. “Is this about the earthworms?”, she asked.<br>\
 The voice that answered this venerable sage was raspy, low, scuttling like a crab past the deepest regions of the baritone. `,
` “Everything will be fine,” the Brown Mouse said soothingly. It was scooping small dollops of blueberry almond jam into indented cookies with the professional competence of a nurse injecting vaccine. Morik, still nervous, decided to crouch in the shade of a mushroom. He could permit himself such luxury — the stalk of this squat fungus was heavenly comfortable to rest one’s back against — because even for a chipmunk he was ridiculously small; it was rumoured that his mother had not stopped at a mere fermented berry or two.<br>\
 Linka, a very august Owl, hooted mournfully from her hollow above. She was thinking that all would not be fine because she had pledged to herself last year to commit to vegetarianism, and yet here were both a chipmunk and a mouse…! It was her fault, she thought grimly, for having come back home. The Wellness Centre on whose grounds she had grown accustomed to eating cheese and eggs instead of vole was very careful in its segregation of clients who might otherwise have aroused one another’s more destructive primal urges. And, back at the Lyceum, high—minded principles had been so fashionable as to decrease quite dramatically one’s chances of coming across bloodshed — unless one paid large sums of money to access basements in seedy taverns, places whose floors were either sticky or gushing with red stuff. `,
` The Dormouse nodded and looked intently at the Heron. It was still clutching pen and paper, radiating eagerness to continue on its mission.<br>\
 The Toad croaked and frowned. It had occurred to that morose amphibian that its interests might be better served outside of this organization of well—meaning but naïve individuals. They had not understood and accepted their dark side to the extent that he had, he reflected; because of both this and their low birth they could be of no further use to him. It was in the interest of creating a clear divide that he was about to expound on his political beliefs about acorns — a hot topic subject this past autumn, it remained just unsavoury enough to shock without subjecting him to future vitriol. But Squirrel chose this excellent moment to launch into a tirade on acorns himself. Perhaps it was because, not having stashed away enough picnicker—peanuts during the summer, he was constantly a hunger—pang away from rage or irritation. `,
` The Kirailoc bandied about on its spindly legs. It was an early execution, this one, and the unaccustomed hour had raised certain suspicions; made it uneasy. To its chagrin, moreover, it had been forced to neglect its usual rump—tightening awakening—ritual. (The Kirailoc species was much beholden to the genius behind such exercises, for the natural state of their rumps was one of such infirmity as to lead, in countless mothers, to death. Prematurely.)<br>\
 The man awaiting death today was tall, his hair curling like rotini, his eyes nearly as blue as the sky. `,
` \"I don't quite understand this principle,\" P.R. Jottingham jauntily announced, his words interspersed with crumbs from an excellent turkey—and—cheese sandwich. His faithful dog Penelope, a large white fluffy sort of thing, barked mournfully at this bit of news. She had been with Jottingham for long enough — and was smart enough of a dog, too —  to understand quite well that whenever he took on this tone, and began to move first one hand in front of the heart, then both markedly forward, that she could not divert his attention away towards either the causes of feeding or petting her until he sat down again. And, also, that monstrously loud applause — like a series of geese departing, or gunshots — was soon to follow. Anticipation of this greatly distressed Penelope, the more so because she had to endure it alone. In the course of thunderstorms P.R. would concede and hold her; murmur soothing long words and scratch behind her ears. During the honking gunshots he basked in a glow Penelope could not understand, that of professional adulation, and he remained transported in some inner rapture that took him away from her even afterwards. `,
` The soldier's pile of gold had long ago been exhausted in various attempts to please himself and Brig; Brig's wine connoisseur aspirations, particularly, had been much nourished during this time, and many a sour green cider had he given, in counterpoint, a sniff. The soldier, to be fair, had enjoyed the blurry parade of oak—panelled cellars and mustachioed men proposing a taste of their finest vintage. He still fancied Brig the most amusing and loyal companion a fellow could have. But Brig's sister had abruptly fallen ill, in December, and loyally had he travelled right over to France to cluck at her sickbed and wipe her forehead with damp _guenilles_. <br>\
 \"Ah! poor Laurel!\", he had exclaimed, \"this happens every so often to her; an unfortunate weakness of the constitution!\" The soldier had found his friend very noble indeed in his resolution, and gladly funded his return trip. He could not have done the same either for his brother or his still extant mother, and he told Brig as much. To which his friend had responded, with a chagrined, loving smile: \"Ah! Maxence, you do not know what the heart is!\"<br>\
 But here was Brig in the _Journal de Paris_, stern and newly bald. The soldier's French had not been of use past the age of fifteen, but still he could decipher \"BLACK MARKET ROGUE MEETS IN PRISON BLOODY END.\" Bitterly he thought to himself of the thousand francs for Brig's return. `,
` The sweater was threadbare, a great many moths having found it tasty as well as alluring. Malvina herself they had not cared so much for, but food is food, and their genetically engineered little bodies bore the digestive equipment of omnivores. It had been three AM when the little girl breathed her last. Now it was four.<br>\
 Schlussel always passed under Malvina's window at four in the morning. It was his favourite part of the day; of his paper—routes. Strangely unalive he felt outside of the job, when time was in theory his, to do with as he pleased. But on the job were immediate constraints, threats to be dealt with, whereas in the loose time of evening fatigue, the weekend confusion of sunrise and gloaming, the things he dreamed of seemed to take more time and money than he could ever afford. And so Schlussel would stay locked into a forlorn state of dreaming outside of work hours. But on the job, there was Malvina.<br>\
 He had first seen the little girl on a walk with a Pram and a Governess; the Pram had brought itself to his attention first, having been loud with hideous wailing. Schlussel, like most of us, could not remember ever having been a baby himself, and so it was very easy for him to imagine he held a grudge against any and all infants. `,
` The penguins waddled daintily towards the wad of bills. The bills in question were purple, not green, and this only added to their discreet excitement, a powerful tremor that couldn't help but peek through as jauntiness and allure in their steps. Purple — printed by the US Treasury last year, under the temporary president Jacopo! It was the magic money, and nowhere near were there thieving grasshoppers.<br>\
 The troop of walruses displayed an altogether different level of interest in its designated bait, a barrel of fish. It wasn't the fault of the fish; not the mishap of a careless supplier. They had simply been told, last night, when their train car passing by another wagon had stopped, that edible lures were common in the place they were being carted to, and that they had better remember their aims if they did not want to end up docile and prim. Wilbur, their never—acknowledged leader, had nodded gravely at Pauline the Pig as she said this; he `,
` Twitterings echoed round the Valley: twitterings and chirpings and echoes of loud, blissful snores. The Hlifnap is asleep again, Cristina thought, not without a tinge of remorse. It was partly her fault, on account of the berry she had slipped into its Parsley—mug; while it wasn't a sure thing, Perforvid Berries were likely to induce some state of doziness in mammals, and their water—soluble skins and mild taste were good for surreptitious surprises. It was hard, usually, to surprise the Hlifnap.<br>\
 Cristina had first heard of the Hlifnap in bed. It was her childhood bed, a wonderfully soft mattress on the huge frame her father had carved for his two daughters out of sweet—smelling pine. She and Melissa had been waiting eagerly: first came the tucking—in, then the forehead—smoothing, and finally the barrage of requests for a bedtime story would be let loose. Sometimes Mama conceded readily, eagerly; other times she would leave with a mysterious smile tugging at the corners of her lips, and some vague expression related to \"you'll see.\" The worst, oddly enough, was when she settled down to tell a tale even though her heart clearly wasn't in it. It made them feel guilty, the strained look to her face, the slightly bulging eyes. And yet they both knew they had never asked her to stop. `,
` Boinder croaked loudly, with as much pathetic weight as his voice could carry: \"I'm coughing up blood, Sandra!\"<br>\
 Sandra, who was feeding their monstrously large chipmunk (Pipsqueak was by this time the equal of an Abyssinian) something gelatinous in the kitchen, maintained a remarkable state of sangfroid upon hearing this announcement. \"Well, darling,\" she replied, scooping quivering green detritus into Pipsqueak's gob, \"we all have to die sooner or later.\" Her husband, disheartened, moaned.<br>\
 Three blocks down Elm Avenue terrible things were happening to Pipsqueak's cousin, Bettina Schoob. A flock of Canada geese had decided to pass part of their voyage of migration on her owner's fine artificial pond. Unfortunately their hunger was by now as much a part of them as their honks, and in Bettina Schoob's tender soft expanse more than one bird had perceived distant food. `,
` The hour of the shooting was nigh. Private Squirrel was readying himself, downing an acorn of hazelnut liqueur and packing stars into the handkerchief he carried on the sly. (This latter preparatory action was not so difficult to carry out as you might imagine: think of it as fishing spoons out of a messy sink.) As the liqueur went to his head and fluffed up his ragged tail he thought fondly of his three children, of how at breakfast they had persisted in switching each other's little bowls of oatmeal about. (Private Squirrel's family was civilized enough to borrow from its human neighbours, at times, and to make intelligent use of items such as a discarded microwave.) This image gave way to images of Sergeant Ostrich winking at him, and soon Private Squirrel was shaking his head, cross—eyed, as if this could void him of imagining; as if his eyes held the power to redirect his head.<br>\
 But his left eye thrust upon him, indeed, the sight of a Morvid Mirrel. This reminded Private Squirrel of his stars, his pistol. He loaded a shooting star into the barrel — this was not unreasonable, Morvid Mirrels being slow though extremely deadly — and repeated aloud his vow to void the town of these vicious beasts. The Morvid Mirrel, meekly, shouted: \"Mummy!\" `,
` Once upon a time there lived a fat little Toad that suffered from a severe Malady. No, it was not something akin to Diabetes or Arthritis, and indeed it was not related to the Toad's being fat at all. (I thought you might ask.) The Toad, alas, craved to be adored and catered to at all times — and that, perhaps, is the greatest malady of all.<br>\
 When the Toad's wife caught a light Amphibian Flu he was most aggrieved that she did not tend to their burrow as well as usual. (How he had managed to attract such a fine housekeeper in the first place I confess I do not know.) When a Mole residing nearby complained to the Toad about snow drifts stopping up the entrance to his extensive series of underground tunnels, the Toad had undergone most extreme throes of agony, thinking how insensitive it was of the creature to flaunt his rich abode with such pretext of woe. Why, he and the missus had near blown out their backs shoveling their mere modest burrow back open to the winter air! When the Mole punctuated his mild grouse with the revelation that he would soon die of the long—term complications of anemia, it had been difficult for the Toad to avoid gleefully screaming. Such was the Toad.<br>\
 To be sure, I have not provided you with extensive evidence of his poor character and wrongdoings; but, in due time, over the course of the action, you will be acquainted with further proofs.<br>\
 Now, it so happens that the Toad was `,
` The monkey grabbed the malachite figurine with many hoots of astonishment. Santiago jammed his fists against the desk, propelling reams of paper into the air. \"Ludowig!\", he wheezed, \"why is the creature in here again?\" (Truth be told, he had not noticed the little scoundrel until the hoots. There was something to be said for its silent, surreptitious search capabilities.)<br>\
 Back in the kitchen, Ludowig took the wooden spoon out of the saucepan, gently letting tomato sauce drip back in before laying the spoon on a plate which also held tongs, a basting brush and a spatula. \"My Lord,\" he shouted, \"the guards assured me last week that the monkey had been savaged by pigeons! I had no idea —\"<br>\
 Santiago whirled into his butler's line of sight. Evidently his rage had superseded any concern he might have had for the various antique furnishings of his office, fallen as they were into the excited clutches of the Primpton Zoo's most notorious refugee. `,
` \"Comrade Zheltsina!\", exclaimed Cristina Samodeyatelnost, \"you can't wear a blouse like that to the Honourable Ball!\" <br>\
 And indeed she couldn't. The amount of cleavage it revealed was a measly two square inch surface — far from the mandated five squared inches requiring some depth. Larisa Zheltsina, however, remained unmoved, pursing her lips into a frown that was really a variation of little consequence on the expression of her general poor mood. \"Comrade Samodeyatelnost,\" she stiffly uttered,  \"today I had a sandwich for breakfast.\" Cristina began to open her mouth in surprise, then sniggered. \"Very healthful it was, I'm sure,\" she commented, full of mock sincerity. \"Exceedingly,\" replied that grave brunette who seemed unlikely to have touched any man, excluding of course handholding, as a child, with her parent. `,
` \"You can't imagine the surprise I felt when I learned that my mother is now a radish!\", Nadezhda exclaimed. She interspersed every couple of words with a judicious peck of sturgeon eggs, which she was delivering from their great glazed navy bowl unto herself in a silver spoon. Her colleagues Anna and Karolina were listening, rapt, snow only just beginning to melt from the modish caps on their hair. Both involved at least some semblance of fur, which had been modified in an inexplicable way.<br>\
 \"My God,\" breathed Anna, pulling a shining metal compact out of her purse to verify, in its mirror, whether mascara had migrated to her under—eye region or not. To her surprise and delight, the mascara coat had not succumbed to the many bold attempts of the snowflakes. Nevertheless, this was a good opportunity to touch up her blush. At work with the powder puff, she confessed that her mother—in—law was turning into a radish, too, and that she was unsure how to cope.<br>\
 \"Leave her to her own devices,\" suggested Karolina. She was by the open window, that she might have a smoke without spreading the smell to the apartment. This plan, of course, was ridiculous `,
` \"I'm cheating on my Grandma,\" Victor confessed. He looked genuinely ill ay ease, Morgan thought, except not quite in the way that a man committing incest with a woman fifty years older should. Personally she could not help feeling disappointed. Victor, up until five minutes ago, had seemed to her so delightfully clever and bold.<br>\
 \"I'm surprised that you dare speak to me of such things,\" Morgan snapped in response. Eventually; it had taken her five minutes to compose her thoughts.  `,
` The peacock feathers in Maria's fan wafted enticingly before Nimmrick. He was lost… He was dreaming! Dreaming; it must havebeen too warm in his cozy bedroom, his stomach must have been too full of beer. It was safe, therefore, to grab a discard of peacock. No fowl would attack him afterwards.<br>\
 Yet Marina's shriek, when Nimmrick tugged at a feather in the middle, was surprisingly loud. Almost immediately the tortoiseshell puss lounging on the grand piano, with its flat crochet hat on top, turned into a redhead in woolly coat and cap. Nimmrick, dazed, blinked.<br>\
 \"Oh, great Wizard, quench my thirst or I shall die!\", the warmly—dressed beauty begged. Bewildered, he ran to the kitchen to grab her former appearance's bowl of milk. `,
` Amethysts were pouring from the barrage of storm clouds, crashing down into the trees and hills. Corlyn crossed himself and thanked God all—merciful for having given him the prescience to pop into a hole. The Old Mole's Tunnel, as he called it; a large network of passageways which he had widened, over the years, since he was significantly more than two times as large as a squirrel. He had also added a stone slab for a lid at the entrance, and this had come to no end of use during the abundant Gem Rains this October.<br>\
 Corlyn's mother had told him, once, of seeing Topaz strike wearily at Seltzyn Beach. One gemstone, then another, had plopped discreetly by her wrist, her cheek. The rest, a meager lot, had ornamented the decaying bench and winked the possibility of finding them amongst the waves. Corlyn's mother, unspoiled in miracles, had simply laughed and laughed for joy. `,
` When the Plingagongel slept it drew a forepaw to its lips. It looked so innocent!, thought Chelan, its superintendent, wistfully. In its waking hours the Plingagongel tended simply to bait and terrorize people — as Chelan ordered; as Chelan's superintendent, the Marquis de Carabas, ordered.<br>\
 Chelan had been working the late shift of ill repute amidst all but the ladies of the night when, one Monday, he woke up early and went to the Old Mill which had been the site of so many of his childhood imaginings. He, too, was a miller's son, but at Newmill nobody seemed suited to start following the advice of cats up to onset of marriage to a noble. He was the youngest brother of three, though, and could not help but wonder whether upon his father's death for him, too, marvels could occur. Old Mill being delightfully overgrown with berries and its water not sparse with frogs, Chelan liked very much to bring himself there for his wonderings.<br>\
 Yet on that autumn Monday he did not find himself alone. A handsome middle—aged man, his doublet embroidered with cloth of gold, was by the doorway (though derelict, the Old Miller's house was still standing), sobbing. It made Chelan feel uncomfortable `,
` The clutter of sardines in Purrmin's little kitty bedroom was unappetizing even to this known devourer of fishes. For one thing, they were off, by the smell of them. Must have been left there for three days at least of this wretched summer heat. For another, Purrmin shuddered at the ruination of his shag carpet.<br>\
 All was still in the house. He could hear a silence heavy and rich in its torpor; the invaders, whoever they were, had not stayed behind to pillage and plunder its rich spoils. <br>\
 Unwillingly Purrmin recalled [12:38] a time on the sofa with Vatin and Tyushina. A blue—eyed man in a suit had been twinkling his eagerness to defend his great country into the camera. Tyushina had laughed at the \"pretty boy,\" but Vatin had looked grim. \"Now, all we have to look forward to is the day he shuts up,\" he'd said, frowning. \"And for us the first time he does will be the worst of all.\" Purrmin realized he could now agree. Vatin and Tyushina, with their pratings and endless combings and preenings, had gotten on his nerves so keenly that he'd begun the metamorphosis into a hisser and shrieker. And yet the root of their absence was more bitter to him than ever had been their company. `,
` \"Next weekend,\" pronounced Emmalyn, \"let's procure ourselves some caviar. Through my neighbour we can get ourselves a deal.\" Emmalyn was playing it cool, her movements lithe, her voice light and careless, but a certain live interest in her eyes gave the cat away. She was ready to shell out as much as a hundred for this delicacy, and this year she was barricading the fridge for the duration of this esteemed substance's séjour therein. Not from herself, of course; nor from her husband, the second bearer of the key. But her dearest — the fluffy little Nootkin — had made his interest in salty fish egg indelibly plain during last year's festivities. `,
` King Ergentlich peered at the gems by his breakfast plate — bacon, eggs, guava — with begrudging misgivings. Emeralds, rubies — or was it garnets? — were interrupting his enjoyment of a meal prepared precisely according to his specifications, and to what end? They didn't have the resources to add any of these to the Royal Collection at present — and, besides, it would have merely added fuel to the claims of those pretenders the Rilsigs, that the Royal Consort was a spendthrift who couldn't handle possessing a mere three tiaras of state. (As it was she could not help alternating them between successive balls and such, festooning them with sprigs of whatever flower was in season, and holly or pine branches during winter. She claimed with full sincerity that this was an ingenious way to acquaint the populace with their country's flora, and promote patriotism. Yet Ergentlich had caught her late at night, flicking through photographs of Queen Krasavitsa: \"Her Best Hair Days: See Her Majesty's Twelve Diadems Done Twelve Hundred Different Ways!\" The worst thing, too, had been how she'd wailed and cried that Krasavitsa, though she always looked different, always looked the same. Regal.) `,
` The Tsaritsa Antonieva was very offended to have been invited to a gathering where barley whiskey was being guzzled indiscriminately. Sir John had no right to hold people hostage like this, captive to his foolish whims of merriment! This was a Court, after all, and not some lowly knave's stable.<br>\
 Antonieva tugged at her pearls and hoped desperately that Tsar Yelyantyev would finish his suckling pig soon. Surely the interruption of that pleasure would free him to consider his wife's imminent turn at the Barley Rig, and chivalrously snatch her away to their quiet chaise longue. It never would have occurred to her, of course, that Yelyantyev was not the kind of man to leave a diplomatic event early, regardless of the amount or quality of alcohol to be drunk. Neither would the Tsaritsa have thought of herself approaching him, such an admission of weakness being beneath her.<br>\
 Really things could have gone much worse for the Tsaritsa. The trip to London itself could have taken the usual three months, had they not met at the dock that odd little gentleman sporting on his brow a green turban. `,
` There was very little honey left in the hollow of the tree where Shurik had placed it. He found this very unfortunate, notwithstanding the fact that he had not brought much there in the first place. But the need of Elena Vasilyevna for honey being very pressing, and his need to please Elena Vasilyevna being very great, Shurik resolved there and then to procure her an abundance of honey from somewhere else instead. I can go to the Volga instead, he thought; Yes, Yes, I will go to the Volga instead.<br>\
 By the Volga there was one grove of birch trees in particular which had been favored by honey—bees as strong supports from and against which to build the honeycomb which they filled in legions. Shurik had the good fortune both of living near this spot — the Volga was very long, after all — and of having a Grandmother with a sweet tooth who knew all about these kinds of things. (She also knew which mushrooms to pick in the forest, and was very decisive about them, unlike Shurik's mother who would always hem and haw about whether they were in front of real orange _lisichki_ or merely their impersonators.) So he rented the appropriate costume for a friendly sort of price from his old schoolmate Vanya and set out to the riverbank with a gun. `,
` Nobody had warned the Squirrel about the Tinnishton; it was enormously delighted to hear the news from its friend the Rabbit. \"I never ever dreamed my humble little tale could warrant this!\", it cried, its tail twirling here and there as if it were a furry cord of feeling. \"Oh, Rabbit, do say you'll come with me to the ceremony!\" Rabbit was Squirrel's dearest friend, after all, and Squirrel likewise happened to know that its long—eared companion and confidant was currently in greater need of consolation than usual. This, in Squirrel's book, was not unlikely to flow from the consumption of quantities of spiked eggnog. What a good thing it was that the Squirrel could drink alcohol if it wanted!<br>\
 The Squirrel had not always been such a fawner; indeed, he had accrued the benefits of his position without giving either bribes of acorns or honeyed smiles to his employer, the Snuffler. `,
` Solfeggio poured some more Anise—Flavoured Whiskey (No Name Brand) into the large tumbler emblazoned with flowers in gold leaf that was one of his few keepsakes of his father's. Keepsakes; that was probably the wrong word for it. It was an heirloom — part of a brandy—serving glassware set reduced to three tumblers around their pitcher — that he was keeping as a memento. Solfeggio's wife had suggested selling it multiple times already, but he had stood firm. It was important not to let that unbalanced woman take too many liberties, for once she'd managed to claim one sort of force for hers it was hard to get it out of her death—grip. Solfeggio's Monday and Tuesday evenings were still in her jaws, no matter how many conversations they'd seemed to have about them. Yes, seeming was just the word for it, thought Solfeggio: even though he was quite certain the conversations had been had, would have been willing to bet his mother's life on it. Because the words coming out of his mouth had only seemed to have an effect on her, to cause her to reflect, sympathize.<br>\
 Of course, unbeknownst to `,
` The other shore of the Neva was growing nearer to the little mahogany boat being peddled by an albatross.<br>\
 Marino Featherbright was the best boatsman in the river—crossing business, absent a scandal or two (he had always been excessively fond of drink and betting), and those who hired him knew it. They could suspect, initially, as their pockets grew remarkably lighter from his initial fee; surely only real talent would demand to be thus paid. But the suspicion developed into certitude as Mr. Featherbright navigated adroitly past sirens, aquatic manticores and various other nefarious creatures of myth. Many were those who wished to reach the Edenic Shore of the Volga, but very few those who managed to succeed.<br>\
 Hector Whitefeather had decided to try his luck  crossing for his family's sake. Such had been the explanation published in the Daily Squawker's prim obituary, paid for by his honourable Aunt, Duchess `,
` Lavinia was sad, as she was wont to be, and Goldenrod was patting her back soothingly. It was customary. Any sincerity there had been to the gesture had seeped out long ago. Lavinia, with her strange moods, her fickleness, and her obsession with her fading beauty, was off—putting to all but the dwindling corps of disciples of her breasts, or blue eyes, or sweetly—placed mole. Yet she remained Goldenrod's sister.<br>\
 Goldenrod had become very active on the Elderberry Council `,
` To Douglas' immense surprise, the yeasty dough he had intended to shape into twelve cinnamon rolls was a spirited rapscallion. A little flap of dough at the end he'd been grabbing blew a raspberry, without any warning; and suddenly the whole white ball was soaring off the table, landing with remarkable grace (it moulded itself into a cat—like shape for the perfect landing) and then tottering away, suddenly a lumpy figure on two legs. Paws? Things.<br>\
 Douglas hadn't left that cream cheese to soften on the counter for nothing. He was determined to repossess his escapee. How dare it make a claim to selfhood? That sort of thing he could tolerate only in an especially pretty girlfriend. It was absolutely out of the question for something that required proofing.<br>\
 Douglas' introduction to self—producing baked goods, like many of his dearest blokes', had taken place fairly recently, during a sprawling time of forced captivity that lady friends seemed intent on parceling into discrete packages either by reproducing with you or by laying weekly doughballs. Doughballs it had been, for everybody but the hapless Pete. But Douglas, instead of the expected dullness, had found himself immersed in a magical world of secret ingredients and bakery—quality goods. `,
` \"What would make for a good horror story?\", Erica the Hedgehog asked her friend Molly the Weasel. Molly shuddered and said, \"something to do with iron and bleeding to death very, very slowly.\" Although she delighted in the blood and flesh of the chickens of nearby farms, she lived in mortal terror of encountering a steel trap like the one that had decimated her Uncle Clint. (Also she was not sufficiently knowledgeable about metals and alloys to distinguish iron from steel.)<br>\
 Dina the Deer, who was frolicking in the clearing where this conversation was taking place, decided to confess her own greatest fear. \"Being sucked dry by leeches,\" she stage—whispered. Then she shivered and looked at her front ankles. Still sometimes she woke up in a cold sweat from a dream in which, gently having entered the lake from which she was especially fond of drinking, she was aghast to find its waters suddenly teeming with leeches, and the creatures beginning to climb up onto her torso, her neck, her head: all from these two humble points of entry, her front legs. The dream came from the more subdued reality of one bygone fall outing. `,
` \"I might be from Canada, but I don't speak French!\", revealed Cynthia to the other ladies and gentlemen who, having lacked the foresight to make a reservation at the Poisson d'or, were sitting at the bar. It was a lovely section, to be sure: the aquarium bar—table (which boasted thirteen lionfish and a seahorse) was but one part of the enchanting picture summoned into being by the eccentric Lee Watts and his three—million fortune.<br>\
 Cynthia had actually run into Lee Watts many times, over the years, back when he was still alive. Their first altercation had promised, or at least threatened, to be their last — for he had struck the young woman down with his car. A poor reward for one attempting to reach the Museum of Fine Arts, Cynthia had croaked to the teary—eyed sexagenarian from her hospital bed. This reproach had extracted both tears and keen, unwavering loyalty from Mr. Watts, a romantic at heart. By the end of the first week of their acquaintance `,
` \"That's it, sir!\", cried the Kriznavong, rubbing his palms eagerly, as if he were in the process of flattening a cylinder of plasticine. \"We'll extinguish the Blivenots with time to spare for tea and supper!\" For this Kriznavong, you see, always had his priorities in order: and tea was third, supper second.<br>\
 Green Gentleman fondled the giant ruby cabochon on his left index finger and kept his face in the light frown he had taken to bringing to work. \"He's been moping ever since Masha died,\" his ever—stylish, ever gossiping secretary Lukasitsa was fond of whispering to coworkers during a lull in conversation; to appease, with this tidbit, if they were being short; generally, if the mood felt right. (For whatever impulsive decision of which the result did not agree with her, Lukasitsa had struck upon the ingenious stratagem of blaming the moon. \"Ah, it was very greedy of me to accept your chocolate when I'm on a diet,\" she'd said that very day to Pyotr Illyevich from Terrestrial Accounting. \"Under the influence of the waning moon I am compelled to act self—destructively,\" she'd added with a sad smile.) `,
` \"Well, Prime Minister,\" — the intrepid huckster addressed thus his housemaid — \"what is your verdict on the new cleanliness laws? Do you find them discriminatory?\"<br>\
 Naturally there was nothing of this sort in his new stipulation that Frieda clean the bathroom daily, and that she never forget to iron the laundry. But it often came in handy to the heinous huckster H. to stir the pot. Hot, aromatic, spicy, cold… Ah, the soup of discontent was `,
` In Spritz' trowel the orange peels were of many colours… and amongst them — yes! he was not dreaming! — right in the middle, as if it had moved there to greet him itself, was the Belgian Topaz. Spritz howled with delight as he began a jig, topaz glinting in the moonlight.<br>\
 On an overhang not far away three National Park Goblins shuddered at the eerie sound echoing all about, as if hungry for moonlight. They had been toasting that most exquisite of delicacies, previously canned water chestnuts, by the fire, as well as looking forward to roasting the lone mushroom they had found earlier, by another fire—pit; but now, as the small creatures panicked and took inventory of possible weapons at hand, the water chestnuts were tossed aside, one indeed rolling up to the edge of the cliff.<br>\
 \"Coyotes can travel in groups of as many as thirty—three,\" Ending dutifully reminded his colleagues.<br>\
 Ending's mother had been fairly superstitious, and the year thirty—three hundred of our Lord had been slated as final by a fortune—teller she especially esteemed, for previously having predicted the return of autumn: the august Horsinda. `,
` The moon, near—full, was not ready to peek out from behind the clouds just yet. When a sliver did reveal itself moments later, it produced the effect of a woman taking off her stocking, or revealing the nose and lips concealed by fan or veil. Aguecheek checked the time on his narwhal watch piece and noted down duly, At seven thirty moon peeped.<br>\
 There was a game between Aguecheek and the rest of the world, Aguecheek knew this. Things were determined to play hide and seek with him, in fact they were so determined that they had formed cordial agreements to take turns, in order not to confuse their Messiah with the dizzying abundance of their ilk. Aguecheek, of course, had been enormously flattered to hear this from his Sister Proletina. `,
` \"Elixirs, fine elixirs!\", cried the merchant Flebimbotton. He cried this same slogan every ten seconds or so, and a note of desperation was beginning to creep into his voice, in spite of his many years of experience enthusiastically hawking dubious wares. This was partly because he was getting older, and noticing more and more of his former classmates passing by his kiosk as quickly as they could, noses turned up, wearing fine silken clothes from Turkey. The other part was due to the elephant he could hear in the near distance. It was the second time this week.<br>\
 On Monday the gray creature had stomped into the marketplace with gusto, pushing down stalls and pursuing any resultantly rolling items that were round in shape. Afterwards the town criers consolingly announced that no souls had been hurt during the elephant's marketplace visit, and that all damaged wares could be reported to the Vizier as offerings to the elephant—god Ganesh. But such piousness did not console Flebimbotton, who had lost a month's stock of potions. He'd stayed up till 2 am wondering what to bring to his stall on the morrow. `,
` The tree was deliriously heavy with fruit; it needed harvesting, Fronian thought, if it were not to collapse into hysterics. He had witnessed a pear tree do so, once, and it had been dreadful. The sound of it all had been the worst part: first the splitting of the trunk, then the thud, and finally hundreds of wails in canon as the rest of the orchard mourned. That pear tree's brothers and sisters may not have been able to attain fatal levels of hysteria, but boy could they wail.<br>\
 He could think of it in a detached manner now, yes, but it remained Fronian's darkest moment. Every once in a while, his wife reported to him of night—time screams she could not rouse him from, and he would look anywhere but there, at the pear branch nailed above their dining table. In his nightmares the dryad of that dead tree buried him in rotting pears, giggling as wasps burrowed out of the over—ripe fruit and into his body, giggling as pear sludge poured into his mouth and wasps followed it there.<br>\
 He had not ensured a harvest of her fruit the proper way, though being the landlord, such was his duty. Until his death now was he guaranteed nighttime visitations by the ghost of the pear tree. `,
` The soup was oddly cold, considering that the stove had been turned off but recently. Erinnera shrugged and brought her chilly bowl over to the seat beside her roomate and erstwhile lover, Chingabonza. Chingabonza was drawing a pelican on a piece of carton known as a cereal box up until that very eve.<br>\
 \"Can't you use real paper, for once? Cheapskate,\" Erinnera lobbed. <br>\
 \"I'm saving the planet and proving my resourcefulness,\" retorted Chingabonza without raising her head from her drawing. The pelican, it was being revealed, directed its hungry gaze at an airborne fish. And now that fish was gaining its own pelican, as flight vessel!<br>\
 The door to the apartment was unceremoniously opened, just then, by Povil, a non—descript door—troll just slightly under thirty. Sometimes Erinnera wasn't sure whether she or Chingabonza had met him first, and she knew this didn't speak volumes of their inter—gender friendship. Nevertheless, she was convinced that he cleared their entrance door's aura at every visit; and this, in her mind, was reason enough to manufacture goodwill. The right energy, as she saw more and more with age, was hard to come by. `,
` The gun was neither in the pumpkin, nor in the enormous jug of eggnog. Sizzer frowned, folding and unfolding over and over again the anonymous note which had promised \"Gun in your food.\"<br>\
 He'd made his request to the Universe in standard fashion, writing in a mix of blood (his) and burdock \"Please furnish me with a weapon by Monday. Provide it discreetly thanks\" on a store—bought greeting card before solemnly burning it in his backyard, by the rosebush, on the principle that its thorns would aid in summoning harmful weapons. (He knew from bitter experience that some weapons, his tongue included, could not be harmful at all.)<br>\
 The gun had become essential, in his mind, on the day the mailman came late. He had very much needed that new, luxurious harness for his nine AM encounter with his new client Jess, for therapeutic exercises which would empower her to speak through the equine part of her essence. (It was a luxury harness because even in horse mode Jess couldn't fathom wearing cheap pedestrian gear. Growing up, she had been trotted out in a revolving door of frocks to each and every occasion, as if she were a public—facing royal, and she had been pleased enough with this habit to see no problem with persisting in it.) `,
` \"This accusation is completely spurious!\", exclaimed the Hatter, wiping crumbs away from his maw. (You may think me terribly rude, for referring to a \"maw,\" but in truth this Hatter happened also to belong to Bearkind.) \"I am innocent of any and all crimes whatsoever!\" <br>\
 The Judge, an Owl, remained unblinking, and in spite of his comparatively awesome size the Hatter was unnerved. Taking a discreetly deep breath and harnessing the soothing power of Visualization by imagining himself at liberty, in a nearby period of youthfulness, lounging by a pool in Nice (you could tell it was Nice because of the architecture.) He would be surrounded by lounge chairs, and the lounge chairs basking in half—naked women, and the women clad in dainty hats of elaborate make. He would beckon to them with a silent imperious paw and, one by one, they would approach to greet him with a pirouette and a deep bow next. The twirl to permit him a view of their hats in action, the bow — a time of leisurely inspection. `,
` \"Oh, Nimbelgottur!\", cried Zoraya. She was a pale young lady whose extraordinarily lush and dark lower eyelashes, some claimed, made her look like a sad clown. Her hands were wringing at that moment in a frenzy of sadness, certainly — as well as fear, concern, and perhaps even anger at having to take action. Nimbelgottur, on the other hand, seemed a placid little boy of two.<br>\
 \"I can't help it,\" he replied, in a deep baritone. His face, while pudgy and darling, with soft blue eyes and curly blond tendrils staking their claim to his forehead, showed a strange lack of animation. \"They just drive me out of my mind.\"<br>\
 \"But five attacks in three days!\", Zoraya wailed. The handwringing appeared to have exhausted her meager reserves of energy, and now she was fairly swooning onto the floor. Thankfully there was a crystal table right by her, which generously scooped her right elbow and therefore the rest of her away from a resounding fall. Distracted by this reminder of the object's presence, Zoraya gave its surface a quick look. Oddly—shaped bronze keys, an enameled bowl of sweets in shiny lapis—colour wrappings… Suddenly she was very alert. \"Is this where you hid the Antanamasi?\" `,
` Leeka rummaged about in the tall grass, searching for a shell that was yet whole. But shell after shell she picked up cracked, broken. One, larger than the rest, turned out still to contain a poor smelly wretch of a snail. Automatically Leeka shrieked and threw that thing away. Not even later did she wonder whether it had had some life in it yet.<br>\
 The afternoon continued to blaze on Leeka's head as she cried, letting out all the misery accumulated over a fruitless day of searching and increasing hunger. Why hadn't the Witch given her better direction? Why hadn't the furry Tadjik agreed to help her? Why had the cookie in her rucksack been yellow (lemon) and not pink (strawberry)? Leeka was getting around to the comforting, mesmeric thought of lying down on the nearby train tracks, and this in spite of new ads warning one that it was BETTER [to] SAY \"I'M HAVING DARK THOUGHTS\" TO YOUR MOTHER THAN [to] NEVER SAY ANYTHING AGAIN, when she felt a light pinch on her left buttock. Startled, she turned around. A queer little pixie was pulling faces at her, its torso bare. `,
` Cries rang throughout the Great Hallway, cries and bangs against the ceiling and heavy landings. Spitzer ran through the chaos, nimbly ducking the Gollowers falling back from the painted ceiling, and keeping an eye out for the lost Duck.<br>\
 He had come to the Honorable Dudgeon intent on service at the age of eight. Very seriously he had asked the herb—wife by the animal pen — as nobody had permitted him entry by the front door, nor even acknowledged his knocks or cries, he had taken matters into his own hands by inspecting the rest of the property — if her employer needed a security guard. The herb—wife, arms full of nettles, had witheringly told him to let his brother make job—seeking enquiries on his own, and to return to the nursery whence he came: for Spitzer had been obviously well—tended—to, back then;  a far cry from his current matted, ratty demeanour. But Spitzer had stood firm in his quest for employment, and eventually the softening alewife had told him that he could wait till nightfall for the Dudgeon's return if he helped her to clean the Goose's pen. `,
` Vodislav realized with an ancient knowing that a planet was streaking away from its distant firmament. That is, he could see the shooting star well enough, but the quiet pleasure and excitement circulating through his being — a feeling of rightness; a feeling that something, at last, he had achieved — constituted some primeval response and understanding of a greater scheme of things.<br>\
 Vodislav had come to the City with a plan his own energies were already keen on thwarting. He had hidden two daggers in the seat of his trousers, for one thing, daring both the gate guards to catch him and the possible slicing of his buttocks. The daggers were of the least worthwhile use to him, too; he could not paint with knives, as accepting of his art as the Fahleks were. Secondly, he had picked a fight with the Genie that, on Sundays, left the apartment. It had gone a bit like this:<br>\
 Vodislav: I'm running so late, Genie!<br>\
 Genie: My good roommate, is it not your very own fault? Did you need every second to comb and shape your whiskers?<br>\
 Vodislav: My whiskers are the pride of the provincial government, you preening poppycock! `,
` \"I've looked in our archives for fundraising methods,\" stated Konjik, the baby demon in his shirt—pocket writhing uneasily and releasing malodorous fumes. \"We seem to have had the most success —\"<br>\
 \"Robbing?\", exclaimed Oonec. Slight lazy—eye gave his long face just the right amount of goofiness, but that had never stopped him from being the most enthusiastic of petty criminals. The comrade to his left, however, always seemed to be pulling teeth during anything but drinking, and alcohol more specifically. He turned a doleful gaze to the orange he'd been peeling as he muttered a warning. The peel having slipped too deviously from his fingers, Comrade Tajik returned to nursing a pretty glass bottle.<br>\
 Konjik, petting the demon's head in a feeble attempt to cease the flow of noxious gases out of numerous holes, reiterated Comrade Tajik's earlier point. \"Thievery is a one—and—done thing, unless you want serious issues with the Earthly Police. No, our organization's chief profits have come from the sale of Sins.\"<br>\
 At this Oonec's grin faded. Sales he had found extremely bothersome during his brief stint at a brothel. He still bore, as a reminder, a scar on the right side of his —<br>\
 \"I'll do it,\" Comrade Tajik slurred, raising the arm with which he'd been cradling his bottle, \"I'll take over the Spirits —\" and here, alas, it was his misfortune, with his eager gesticulations, to roll his bottle over till onto the floor it fell. The glass shards spread surprisingly far, as did the smell of vodka. `,
` Absurdly, Logrin had not considered whether there would be any money left, at the end of his Enrollment Trip, to give the Commissioner sufficient recompense. He opened his wallet, then his snake—belt which doubled as a stylish (for men of a certain persuasion) purse. Neither contained more than a couple silver pennies, as he had expected. <br>\
 He started to turn his head towards Amanda's palm tree, then stopped; not that he was too honest to expropriate her hidden doubloons, but she would find out within days, and that discovery would drastically shorten his lifespan. Although the heiress his roommate was a stingy sinner when it came to matters pecuniary, she was generous to a fault with thrashings and further threats of violence. It could be hard to understand this even when she caused one to bleed from the nose. \"But she's so small,\" one protested, groggily.<br>\
 Logrin looked at the Commissioner with what he hoped was an ingratiating smile. He had been a real lady—killer, when he was seventeen, for a glorious period of seven months, but over the course of his Enrolment Trip he had lost all of his charisma. He even suspected it had happened all at once, a thunderbolt coming down upon the `,
` \"I'd love to be an intrepid explorer, really,\" Sir Oswald remarked, in betwixt bouts of crunching at an apple. And it was true, and he really would have gone to Tasmania four years ago, except his Grandmother had  had a bunion and he'd been feeling humdrum and it had become clear that he was past his prime for adventuresomeness. He had been able to psych himself up to participate in bouts of the dangerously unusual before, but now marked three years of captivity to Pfurry, and though Pfurry was a fairly civil sort of chap to be captive to, the fact that one could neither touch his financial resources, nor leave the exquisitely large shed for longer than twelve minutes was beginning to wear on Oswald. <br>\
 Not long before his first encounter with Pfurry he had been ostentatiously at large, trawling graveyards in search of gravediggers. It was a superb way of approaching the matter, really, because for all his desire to see what the corpses had to offer he was remarkably squeamish. Unaware \"diggers\" were the perfect middlemen. Sir Oswald's spook costume, aided by their guilty conscience, tended to work like a charm. Gathering scattered diamond necklaces and so forth in the dark moist grass stubble could be hard, of course, but some thieves were so kind as to package their loot beforehand. Someday — when he retired, Sir Oswald thought — he would interview a brave grave—digger or two, learn what had impelled them onto their special journey. They were truly exceptional people. `,
` The lass with the joyous smile and wide, high cheekbones bestowed another flash of the teeth upon Sayorvarle, a simple man in recovery from bitterness. \"My brother,\" she said, excitedly, \"visited a wizard that has just the thing for you!\" <br>\
 \"A paycheck?\"<br>\
 This deflated the lovely lass quite rudely. Sayorvarle could have sworn a hissing sound escaped from her left ear. Having long protected his ears from overloud baroque concerts and yelling couples, he was quite proud of his hearing, estimating it to rank at the ninetieth percentile for his age.<br>\
 What age was this sad little lass, Sayorvarle wondered. Surely no more than twelve? thirty? five? Her height could have marked her either freakishly tall or short. She was ageless, disconcerting. He found himself compelled to speak again on the basis of those reproachful eyes alone. \"Alright, lass,\" he began, taking off his cap. A good cap, suede, of solid make. \"I'm in need of a helping, the basis of manners being on its own sufficient. Where say ye I should go?\" `,
` There were many needles in that dusty dark basement corner, relics of a time when tapestries were popular and a lady couldn't get married, respectably, without embroidery. Trollig began pawing through them, unheedful of getting pricked: the skin of his hands was as coarse and thick as an elephant's behind. What was at stake, moreover, was his father's kingdom, and therefore he would have leaped to search for the Golden Needle even had his skin been paper—thin.<br>\
 When Trollig was very little his royal father had been very busy, naturally, with matters of the realm; war with the hippogriffs was never too far off, nor were the mermaids ever less than three shakes of the tail away from scheming to make the two—legged pay their dues to the aquatic beauties of their native land. And Trollig's mother had been dead, naturally; in a different sense. Trollig had been an infant of remarkable size, and she a waffling and dainty troll unsuited to adventures of the birth canal. So young Trollig spent many an hour dandling on his grandfather's knee, playing the finger—biting game or being read to (for had he been not of Blood Royal, this venerable man would have turned librarian, so far did he favor pages to the inane world of his kind.) `,
` The babe wriggled its toes, at which the nurse nodded approvingly. \"Ee's got 'is reeflexes, ee 'as.\"<br>\
 Tom sighed morosely as he looked from the toothy matron to his spawn and then back again. He almost wished little Ted had been Andrew—from—across—the—hall's, and not his. Perhaps cuckholdry was a state preferable to putting yourself in a situation where you might end up a single father in desperate need of getting laid. Most cuckholds still had a wife in bed, after all.<br>\
 Mathilda had smiled most patronizingly when she left; it still rankled him. \"Darling, I'm freeing you up for the most marvelous opportunity! Pussy will part for you like the sea did for Moses!\", she'd exulted. Mathilda had always fancied herself benevolent, and before she announced her intention her intention to leave him Tom had found this delusion to be of good use. He, fancying himself a miserable wretch, never did anything that might be construed as generous. He and Mathilda `,
` \"The truth is, citizen,\" said the man with a kind, bear—like face, stirring the noodles in the aluminum pot all the while, \"that I don't think I've got anything left to live for.\" <br>\
 Fedya blinked. For one thing, this apparently hopeless fellow was taking up valuable night—time space in his bathtub — gratis! For another, this last statement had categorized him one of those unlike ever to repay his debts. For Fedya liked to take in friends or strangers, really did — always without a word of plaint; but they knew, just as he did, wordlessly, that some day they would move on — or back in with their wife — and he would be left alone. And at first he had prepared to enjoy the solitude with ice cream and solo two—player games of backgammon and parcheesi; with sessions spent covering up his nails, out of a desire to imagine what his fingers would have looked like totally smooth. `,
` The horse was truly gigantic, at least twice Leonora's size. Gimmel walked around it with an appraising eye, inspecting at his leisure its well—brushed coat, its polished hoofs, the strands of snow trailing off around its lips. All of this he was safe to do because Leonora's father, an adequate, if not outstanding, Wizard, was holding the beast immobile for his viewing convenience. Satisfied, Gimmel nodded. <br>\
 He ducked out of the way, startled, when the horse immediately afterwards resumed pawing the ground. Had Leonora's father been finding the stillness spell hard to maintain — was he that low—league of a wizard — or had the abrupt return to movement been a threat, thinly veiled? Gimmel was finding it hard to maintain equanimity, having just almost been trampled; it was of the utmost importance that he learn why now, and the placid expression on Mister Bessver's face — his blue eyes shockingly just like Leonora's — was at that moment infuriating to Gimmel. He would gladly have ordered those two eyes skewered on a stick. `,
` Sontin looked at the palm tree doubtfully. \"I don't want to be stealing no vegetable, Hoss.\" Sontin, besides misunderstanding the vegetal nature of the palm tree, had yet to complete any sort of mathematics lesson. One could only have called him possessed of a love of learning in the context of determining where, in an apartment, the money was hidden. But that age of petty thefts and break—ins was behind Santin now; he'd been hired by Relative Productions for bigger and better things. In Santa Monica they had carried off not one but two marble statues the size of horses, leaving Sontin very pleased with himself. And then they had come to the Ural Mountains, for this palm tree.<br>\
 \"Citizens,\" called out a fantastically red—haired woman manning the customary beachside ice cream cart. Pulling a bell out of her right pocket — her pockets really were large, for a woman's; Sontin hadn't even noticed a bulge — she rang, if not with enthusiasm, with much vigor. Sontin turned his gaze back to his current client, Bob, or \"Hoss.\" They had been travelling together for a week, which, as it turned out, was not sufficient for Sontin to learn what \"Hoss\" meant, nor for Bob to ask about it. `,
` \"Why, goodness gracious, Edna,\" Thoman Wahverton announced to his comrade of fifty years in peoplewatching, \"the Duchess has got on a new diamond and ruby necklace!\" <br>\
 Edna, who'd been participating in subtle activities of orchid maintenance, turned off the faucet and peered at the TV screen. She was far away enough to notice little of what was displayed on that device, but nevertheless she nodded sagely and emitted an approving grunt. It was her feeling that Wahverton must be coddled in those of his interests that she cared little for. He was one of those people, bless his soul, that craved to be listened to.<br>\
 Edna herself had gotten into people—watching precisely because she hadn't figured out when to enter conversation. Watching fervently enough would unlock for her the doors to all social situations, including poetic ones. How Edna longed for such a romantic moment, involving a clever man, a favourite book of hers, and roses! Or, alternatively, a beautiful, sad young woman, very slowly and thoughtfully smoking. It could be drinking; Edna wasn't too choosy. But people—watching did not kindle in her the energy to talk to people of her own, and a poetic situation never occurred. She had met Thomas, of course, but he was not what she would call good—looking. His nose had been bulbous even when they were yet bright things of twenty—eight. `,
` Later it turned out to be significant, that no—body besides Susan had brought oats to the party. But at the time Susie came she had been greeted with the classic hug of Alexandra's boundless appreciation, and only one rainbow—coloured—hair youth, besides the birthday girl and the roommates of her boyfriend, had arrived yet. There was yet the possibility of multitudes more arriving bearing grains of various kinds. And at that time Susie's thoughts had been consumed with delight at the birthday card she'd prepared for this occasion: a veritable jaunt amongst the elves was this pop—up affair, a reasonable facsimile of pages three and four from her favourite book in childhood, Troll Day. (That riveting tale, the account of elves trying to escape a castle overset by trolls at Samhain, had never been a bestseller — and yet, thanks to Susan's attentions and assiduity in polishing her boots, its author and illustrator, Polly Nancy, had decided it was her moral duty to release a sequel as quickly as humanely possible. \"Humanely\", in Polly Nancy's mind, was a nebulous adjective, tied to notions of Swedish work—weeks and hygiene of the soul. `,
` The kangaroo's pouch was enviably petite and delicately formed, like a flower. Carl the crocodile sighed, then focused on a new set of stills. Here was a preening peacock on the phone… eating popcorn… cozying up to the Famous Beaver… deploying attractive calligraphy against a faded blue page. While Carl didn't particularly care for the spread, Oscar the octopus had reminded his staff that some hires based on recent trends were mandatory, even if the contractors' work would only turn out to be seasonal. \"I can't afford to be timeless,\" he'd mimeographed to them, a sad bustle hovering about across from his aquarium. Penelope the panther had been scratching her head so, Carl had assumed she'd come down with fleas. In spite of his annoyance at the sounds, his discomfort from the ibex he'd been digesting, Carl had dutifully jotted down `,
` \"She's thrown her handkerchief to that poxy fellow Brian,\" Tudor hissed. He was far from being a silk enthusiast abashed by such negligent treatment of the material; he cared about handkerchiefs insofar as they demonstrated interest, favor. And he was certain that Brian had by now claimed access to that female horse enthusiast's bed.<br>\
 Tudor's left—hand neighbour, Saul, continued to massage his temples. He was very interested in wellness these days, and, if he recalled correctly pain in the temples was related to neglect of one's fourth chakra. Well, Saul was going to make up for this neglect, there was no doubt about it — even if he had to massage his temples all night. Absentmindedly he looked upon the objects of his longtime best friend's ire. Catarina was a fine specimen who alternated betwixt states of jollity and determination, all the while maintaining a beautiful figure wreathed in fiery hair; and Brian, a notorious cad, nonetheless appeared poised to achieve great success as an astronomer. There was something to keeping your eyes on the stars rather than the maids in your arms, Saul supposed. `,
` For a while after Caroline Ellis called us up sobbing the room was infused with a sick feeling. Our heads felt too big for our skulls. It was Bryan who had taken the call and fairly rapidly, his face blooming into a concerned expression, put her on speaker. She sounded like she was choking; at first I had thought she was choking, and panicked. But then came the first sob. There was a lot of choking that came from the receiver in Bryan's oddly small right hand with the nails bit far beyond the quick, and a few sobs here and there.<br>\
 She didn't seem at all lucid to me at the time, seeing as she remained unresponsive to our numerous inquiries. Bob was first, since Caroline had hitherto occupied in his heart the place of perfection reserved for the sweet, beautiful girl you'd never ask out, no, neither in college nor afterwards, because you're weak and pathetic and only five foot two. (That was how Bob thought about it, don't get me wrong; he was a wonderful chap but he never did get over being five foot two.) \"Caroline,\" he'd said, firmly, soothingly, \"we're here for you. Where do we have to go?\" And he could have driven pretty much anywhere, seeing as all of us but Dana had taken our gas—guzzling chariots to this studiously boring house in the suburbs. `,
` It was a sunny October morning when Matthew, quite abruptly, decided to kill his bride. Which is not to say that Tabitha Soleman, née Travers, had never irked or displeased him before; she had done so, many times, and particularly over the issue of turning the gas—lamps off at the appropriate hour at night—time. But the successful birth of thoughts of murder was due to a byline in that week's issue of the Times: \"Enough to Incite One to Murder.\" Matthew was of that cast of mind which, diffuse in its inner realm, is wont for safety to latch on to passing tidbits of the outer world. In this case, murder.<br>\
 At first Matthew blanched, and almost dropped his favourite white coffee mug. Such a lapse of control should have ruined his lovely green silk suit, and diverted the thoughts of his wash—woman from her youngest son's upcoming birthday, given the delicacy of the task at hand. Thankfully, however, it was with an increasingly steady grip on his mug that Matthew forged on past his initial shock and accepted that there might be many benefits to \"finding\" his wife dead. `,
` \"Wretch!\", the king exclaimed, flinging the long roll of parchment formerly known as a letter from Barlsey far off into the kitchen, where it tottered like a drunk man on its landing before falling off the counter and onto old Jennifer, who was drunk off the remnants of midday's feast and whose tail was batting off flies. Briefly the gentle impact roused that faithful mongrel; just as quickly she settled back into her languorous slumber. In that interval King Benrie had succeeded in trampling three times round Sir Perrival. <br>\
 Sir Perrival, having blanched, had attempted to distract himself from the harangue at hand at various attendant anxieties by envisioning the buxom figure of Bessie Blound, a wondrously beauteous lass who was foremost amongst Queen Batterine's ladies—in—waiting for her high spirits, propensity to charmingly spread gossip, and elegance of dance move in every part. When this failed Perrival found himself hostage to recollections of the scowling furrow. Of disapproval in the agèd face of his mother. As it happens, his mother had been a Duchess of most exemplary sort, minus a scandal or two induced by young blood and lustful inclinations: she had been the paragon of patience, fairness, and virtue in her limited involvement with her son's upbringing. Yet this phantasmagorical recollection of an unvoiced disapproval haunted him to his dying day.<br>\
 That day was not today. Abruptly Perrival joined the scroll by old Jennifer, petting that hallowed creature's mangy fur and whispering soothingly various facts about his assises. He was fairly confident that his case of novel disseisin against Pritchard Maudlein in the Midlands would be uccessful, and that he would recover his finest hunting—grounds from that scurrilous villain. `,
` Gilly looked bleakly at the advertised wizard's robes and hankies. Surely nobody could expect any self—respecting wizard to conform to this demand for taupe? \"We are not interested,\" he began, quietly, slowly, \"in equipping our personnel with your wares.\" Abruptly he noticed the heavy presence of something in his nose.<br>\
 Something began to scratch and quiver there. Gilly shivered with sudden fear. He had heard of this breed of attack twice before: once in a documentary film blessedly focused chiefly on innocuous, harmless parasites, and the second time from his schoolmate Tessa. She had been lamenting an umpteenth brother. \"He ought to have known better,\" Tessa had disclosed sadly. \"He kept telling us about the scratching creatures in his nose. But you don't just leave scratching creatures in your nose, do you, if you're a reasonable human being?\" <br>\
 Thankfully Gilly was nothing if not reasonable on this mild third day of April. `,
` The swan was made of brass, Amir guessed: it had that dull, goldeny sheen. When he was little, he had played, in the mirrored alcove of his father's room, with an elephant and giraffe of this swan's kind. But Amir betrayed nothing of his nostalgic reminiscences to the fattish merchant with lush black mustachios and goatee finely contrasting the pistachio silk in which he was swathed. He flicked a nonexistent speck of dirt off his knee, nonchalantly nibbled at a pear, all to indicate to the merchant how little his presence mattered, and how vastly it belonged not in this space private to a monarch. Yet the consultation room, or throne chamber, extended over a space large enough to warrant, if more than a pond, then not quite an ocean. Such size did not make sense without people.<br>\
 \"My metal menagerie is not accepting new members,\" Amir admitted ruefully. The swan did appeal to him, he knew not if he would come upon its like again, and he could not afford to develop a reputation for being brash and haughty with foreigners. His subjects the Mirocchians were gentle where he was impatient and rude, calm where `,
` The little bearded fairy sat still and moribund on his dull dark toadstool. It was very quiet in the forest at this point of the evening, and especially so because it was Thursday. This day of the week attracted forest—dwellers to the city, inexorably, to harvest some small  joy and diversion from the Wednesday Cupids, idling away their earnings. One of the Wednesday Cupids had attracted a following to the Typical Irish Pub, where he delighted in whist and especially in besting others at it. Another lurked at the Bar de Delinelle, where he tried, in the half—light, to craft recognizable likenesses of the open mic singers there out of clay. He wasn't terribly successful, but as his pastime was a rarity at bars, and he had bribed the manager substantially to let him undertake it there, he never failed to attract curious gawkers. The third of the named Cupids (for the nameless ones merely drank in a honeycomb dorm in the poor part of town, near the end of the smallest metro line) frequented an establishment that styled itself a Café, and claimed for its own the name of that famed final ruler of Egypt. What he did there I know not, but it appears that the establishment is ever willing to hire young ladies desirous of dancing in the nude. `,
` The woman cradled a little grasshopper in her hands. It being very cold, I felt concerned both for this delicate creature and for the lady herself, as her fingers were bare and red. No sooner had I opened my mouth to voice concern that she began to scream, so loudly and savagely that I wondered whether she had received a knife in her innards; though such attacks out in the open were uncommon in our section of the city, they were not unheard of. I rushed to her side to verify whether from any new crevasse there poured blood. My action of concern was met with a most vicious stare, as well as a mournful chirp from the grasshopper. It was all most baffling.<br>\
 Just then my fellow apartment building dweller Serge arrived, bearing a shovel. We would surely have directed at one another our usual three—fingered salute — a tribute to a Magickal Staff we had procured for costume purposes and near—instantly decimated in an accident with a portable loo — had the cowled woman holding her grasshopper not conspicuously been to my right. Noticing Serge's brief bewilderment, I gave that odd specimen of female a more thorough look. For the first time it registered that she was really quite pretty, though laugh lines and a general air of facial wornness gave me reason to suspect that her beauty, free of these trophies of time and worry, had once reached greater peaks. I wondered how she had come upon her grasshopper, and why she was providing neither this insect, nor her oddly little fingers with warmth. Instinctively I reached into my right pocket for my pride and joy: my nautilus lighter. `,
` There was a great deal of berries in that bowl by Miss Pendleton's bedside, and most, if not all of them, smelled to be on the road to highly suspect and foul. I wondered how these berries, obviously once quite expensive — I had not seen a real live raspberry in years, prior to that nighttime visit — had materialised in that curlicued cream bowl with its stubby bronze legs. Had Miss Pendleton, many layers of carpet dust prior, commanded a maid? Had she, perhaps, been visited by a relative with good connections in the Imports bureau (for the raspberries of our nation, I am sorry to say, had gone extinct in the Berry Plague of 1893, and funding had failed to materialize for a virus—resistant strain)? Briefly I considered that Miss Pendleton might have confected the berries from papier—mâché; the repugnant odor was quite possibly due to some components of her fabrication which were more sensitive to the ravages of time than Miss Pendleton herself, who in spite of her distaste for baths never seemed to produce stenches of any sort. `,
` \"Choytingham was adamant that it be sapphire,\"  Eltina replied, tone impertinent as ever. I happened to know, on account of Choytingham being my most cherished friend as well as brother, that she was completely wrong. Indeed I marvelled at what a bald—faced liar she was. I am certain that I should never have been able to lie without the trace of, if you will permit me, my porker shining clear through my forehead. It was this, rather than a faultless conscience, that had thus far permitted a man as low in impulse control as yours truly to avoid jail for thirty—odd years.<br>\
 But Eltina's expertise in counterfeit, on that day, was as useless as whipping cream for neither cake, nor fruit. I signed the paper she had thrust only eleven `,
` Glover was growing increasingly frustrated with the pine tree's refusal to adhere to the hill. All was fair in love and miniatures, but surely there was no reason that this particular tiny conifer should fail to respond to his tender ministrations and a small dollop of instant glue? Of such vein were Glover's innermost thoughts until he heard first an impertinent giggle, then indiscreet scuffling.<br>\
 \"Clara,\" he said, tiredly taking off his glasses. It was not a greeting, but a statement of fact. Here was his infuriating cousin. There she was. It was easier, even if he could hear her, to pretend he saw her not. He was not at present in a sufficiently advanced stage of blindness to fail to note a collection of four pinkish blobs moving towards him.<br>\
 \"Glover,\" she replied mockingly, taking something yellow out of the blur of her personage. Glover heard an indignant squawk, and indeed he himself was growing indignant. How dare she thus degrade the dignity of such a magnificent animal! He was nearly certain that his cousin had stolen their Aunt Mignonette's pride and joy: a parrot Kakopo. In an ecstasy of hate he pressed the button on the underside of the desk lamp he had commissioned made to look like a bronze medusa. His butler, Lomuel, a paunchy man with the quiet dignity of an effective robot, was not long in coming. In his honour Glover returned the spectacles to his visage. Lomuel, he reflected, really was a marvel of elderly constitution. The butler had been a mile away, in the very thick of the Ohmsgate gardens, and yet the strain of his rapid obeyance to his master's summons existed only in the expectations of that same fellow. <br>\
 Clara's attention was on Lomuel too, chiefly because she trusted him to rid her of the less pleasant evidence that for hours to her bosom she had cradled a Kakopo. With uncharacteristic apologeticness she was to admit that the bird had remained marvellously calm and still, save in the workings of his bowels. `,
` \"I consider myself marvellously attractive,\" continued Catherine, with a slight pause to butter, munch on, and return to its fine china plate a crumpet, \"and would hate for my beauty to be despoiled.\" Although she was barely shy of forty, everybody in the room except for Barnes the plumber had to agree that that rich worthy remained striking, notwithstanding her thinning skin and the crevasses which hinted at hers being a regular purveyance of frowns. Still her eyes shone with the vigor of youth, that ineffable sense that the world could be yours, should you but choose wisely. It was this attitude, as it happened, which rendered Barnes insensible to her charms: for he, being a great romantic, preferred most of all the wooing of a woman who had seen it all and vowed to never, never again stoop so low as to conceive of men as capable of sex. Such women had typically stewed in pessimism for at least a year or two prior to their acquaintance with Barnes, whereas the wealthy Catherine had the easy confidence of a man who beds women without trying, and considers his reams of conquests, fondly, as a jolly lark.<br>\
 Javes, the hairdresser, who sat on the far right of this library office panelled in dark wood, was finding it hard to jump between his thoughts of Catherine's locks and the insults he'd tolerated the day before from his wife. It especially bothered him that she'd cussed him out in front of their talking parrot, Pip. He had grown oddly distant from Sabrina's various judgements and verdicts on his brains, his size, his accomplishments; but the prospect of a parrot repeating insults at him he found unbearable. `,
` \"There were no bananas left,\" reported Angus Welch semi—apologetically. That part of his demeanour unconcerned by the matter was focused on scratching his back. He appeared to be having a good run of it too, did Angus Welch; which perhaps shouldn't have come as a surprise to any witness, seeing as his yellow—tinged fingernails were remarkably thick and long. In any case neither Deborah Stuart nor Patsy MacLance were interested enough in the fellow to look elsewhere than at their magazines subsequent to his arrival. The essential part of his message was clear: they would have to seek that tropical fruit curved like a scythe elsewhere. But good Angus Welch misunderstood their silence, and amiably began to furnish them with supplementary material: that these two ladies should know that he really had tried his utmost best to provide them with an object illegal for some thirty years now at market.<br>\
 Oddly enough the ban on bananas had come about due to the waning sentiments of a then less large king. Having gone through many travails to acquire a new wife, he had initially been happy to provide that blessèd creature with the bananas and pomegranates which had once served as symbols of the secret and erotic nature of their love. Swiftly, however, had he grown disillusioned by her fantastic moods and vengeful comments. He managed to have her sentenced to death for a treasonous act involving both bananas and chipmunks. While the chipmunks were forgiven, on account of their positive contribution to the national economy, the import of bananas had been outlawed forevermore. `,
` The small girl with the shirt which displayed for all to see, at face value, her love of the equestrian, sneezed. Her nose felt as dense as a turnip, and this fact in conjunction with the weather left her close to despair. There was the matter, also, of Mrs. Rumblehook. The small girl who was a votary of horses had freshly begun to disdain Mrs. Rumblehook, on account of a comment that harridan had made in relation to her knees.<br>\
 Max Rolfoot, by eleven years the elder of the small girl, never had anybody comment on his knees — in the main because there was an absence of wounds, fresh or old, upon these largely uniform expanses. While Max Rolfoot had noticed something amiss with his sister, he was at a time of his life in which calling her by any designation besides Small Girl would have been unthinkable. It was, he felt, far beyond this period that acknowledging their acquaintance with civility would become permissible. For now he was content to remain far from the earnest cries that would have unmasked him as her relative by trawling the Hawthorne School for Children from Young to Advanced Ages only when and where the schedule in her room — easily enough invaded — had given him to understand that she would not be present. None of Max Rolfoot's classmates thinking enough of his company to wish to sojourn at his house for a game of tennis, such deceit was not too difficult to perpetuate. `,
` Charles the Second was a stern man, but unbeknown to most his third child had turned into a mermaid. The first had grown into a pale and steady disciplinarian, the second was developing into a jocose administrator, and the third had made a shady deal with a crocodile during a pleasure visit to Pern. <br>\
 Genuine crocodile tears, more so than genuine crocodile skins, are reputed to cost a fortune; on account of Charles the Second's not being rich any longer, not since the Beet Crisis of '94, it is perhaps best for us to abstain from inquiring into the origins and nature of the crocodile's received loot. Suffice it to say that imbibing the crocodile's tears proved extremely effective: Houmanine felt a sudden airlessness to the Great Outdoors and a prickling all along her legs, which were growing scales throughout their surface area and merging into tail. <br>\
 It was fortunate for her that a pair of fishermen were on their way to the grove wherein she had dealt with the long—gone crocodile. They had heard of similar goings—on, transpired in the time of their forefathers under these very same willow trees; but on that day they headed to the grove merely because Antoine, of their number, had procured for them a foreign fizzy apricot beverage they were much particular to, and they were eager to enjoy their bottles in a picturesque setting furnished with shade. `,
` Once upon a time there lived a boy with a temper like a dragon's. His parents, meek individuals who nevertheless demonstrated sufficient self—assertion to live from day to day, were both proud of and exasperated by their little one. \"The dragon is at it again,\" they would report apologetically to the one couple that had the temerity to invite them annually around Christmas, as their son demonstrated the latest age—appropriate fashion of gaining dominance over their well—dressed hosts' dopey—looking son. <br>\
 The kinds of incidents as I have just given you an example of, repeated at length under slightly different circumstances, incurred a belief upon the boy. It was an article of faith with him that he was a dragon, although this aspect of his nature remained discreet until he lost his temper. His temper lost, however, either the scales or the flames would cow people into submission. <br>\
 Over the years, naturally, his times as a dragon lost his parents' apologetic refrain and statement of fact; they could not be around with him at school, nor at his friends', nor in the streets where he frittered away his pocket money, and loudly mocked the sleeping bums as good—for—nothings. The boy was perfectly content with this new state of affairs, for it was much more fun when he got to announce, to the victims of import, that I am a dragon, and I will kill you.<br>\
 Initially the boy found disposing of bodies bothersome. His claims being somewhat overwrought, the bodies were merely corpses of birds, stray dogs, squirrels. `,
` Poltroon, Earl of Sussex, faced a dread fate for having broken the King's Peace with a gesture of impact from his fist. He was to relinquish his properties, to be imprisoned by the King at his leisure, and to lose a hand — his right,  which all his life he had favoured more than his left. Poltroon dreaded the loss of this hand terribly, of course, for even as a lad he had been terrified of tickles: and having one's hand chopped off, in his humble estimation, was a form of physical attack substantively worse. But to lose his properties — Grand Eyersville Manor, his hunting lodge in Eowrich, and the former Albertsville Priory, with its fifty acres and well—favoured ewes — why, it was more than he could bear, and shorn of his capacities both for fighting and administrative writing he would be hard—pressed to accumulate new lands through honest work. Not that it was likely that he should be offered opportunities to prove his mettle: the whole court would be present to behold his amputation, and as many men as possible involved in the act itself (the cut, funnily enough, would involve a Gentleman of the Larder) to drive home the danger of disturbing His Majesty's Peace.<br>\
 There was another aspect too of the ceremony at hand which bothered the Earl of Sussex. Poltroon could not for the life of him understand why a rooster should be beheaded at the same occasion, with the same blade — for subsequent refreshment? to demonstrate what was being done to his manhood? `,
` Nampussy Square was remarkably devoid of leaves and people alike on that cold November eve. There was nothing remarkable in and of itself, of course, about the spindly beeches having shed their foliage by that time of the year, but the way they looked that night, bare and distorted, struck me as a stark departure from their usual deportment.<br>\
 I had been waiting for Mildred to come join me at the bench nearest to the Wexley memorial, the centerpiece of Nampussy Square had it not been for the mysterious green staircase towards the back dwarfing it. As it happened I had noticed that as many as three benches were equidistant to the Wexley memorial, and was cursing my poor memory and lack of foresight, when came the first caw.<br>\
 I could not help the slow spread of goosebumps down my back at that sound. Mildred should have abused me for being a baby and a coward, I know, had she joined me already at Nampussy Square. But there she was not, and none of the usual bums had been there either, at my arrival. There were only two living creatures: myself and the source of that caw.<br>\
 I swivelled my head by turns, that the changes might not be quickly noticed, for my goal was to observe the crow without its turning towards me. `,
` Herbert's favourite nostrum against the nighttime throat pains so intimately linked to his conjunctivitis was a blend of bat's wing, cockroaches, salamander tails (a humane choice, this, for Herbert knew they could grow back) and lavender, for taste, as well as a cattail for garnish. <br>\
 Now, one might be inclined to mock young Herbert for adhering to such a queer ingredient list. Some might gently suggest that, beyond the feeble help of tea with honey, the best healing to be expected in this case will come from the passage of Time. Others still might seize the opportunity to sell vials of the Miracle Oil of Montecito, a wondrous cure—all available — most miraculously of all — for a mere forty pence. (Although in some countries forty pence, leaving exchange fees by the wayside, is nothing to sneeze at.) Yet Herbert, he of the then—leaky pink eyes and of the barricaded hooked nose, was young and stubborn: and therefore he was all alone in his shared kitchen after an illicit visit to the zoo.<br>\
 He was about to commence utilizing his immersion blender, having cautiously doused all of the recently living parts of his recipe in warm vinegar, when the lights began to flicker. Dimly he wondered whether his upstairs neighbour Shuriy was at his energetically costly torrenting activities again, for that brave soul's hacking of digitized museum archives had not been unknown to cause power outages before. `,
` \"Are you quite sure the Frolik has to be caught at nighttime?\", Yorrick asked, yawning luxuriously. Yorrick's wealth was self—admittedly in his health, and while ten hours of sleep was a sensible deposit, five certainly was not.<br>\
 Norjack, who'd been lacing his feet into a fearsome contraption that claimed to be a pair of boots for an embarrassingly long period of time, rolled his eyes at Yorrick's question. It was especially pleasing to mock Yorrick because the lad had wonderful calfskin boots that could be gotten on and off by aid of a zip. \"You can catch it during the day, Yorrick, as long as you can climb to the top of Mount Houffleytoot!\"<br>\
 Alleesia gave Norjack a discreet shove in the ribs just then. The boys could be as foolish as they liked — Lord knows they hadn't been any cleverer when they'd agreed to the Plan —, but it was essential that they be kept in check. And just as she'd made the Plan, and found these two to help, she'd take up the reins of moderating their excess.<br>\
 While the Frolik rested its purple little head in a nest made of gems at the very peak of Mount Houffleytoot in the daytime, its nighttime wanderings in the Greater Hiffla Region it pursued always at the same frenzied pace, pausing for some reason at every vineyard in its vicinity to have a drink. Some citizens, having learned this fact through Dr. Grinnenbare's informative capsule  on the evening news, had grown very concerned for the state of their provincial mascot's liver, and sought to raise funds for a clinically—based check—up. But funds were generally low, that year, and donations had barely reached the threshold for a regular doctor's appointment. `,
` Horchaka blustered further at the Impenetrable Soldier, who was very manfully perched atop the chaise longue opposite with Victor, his poodle. \"Diplomacy is very important to the people who rally behind Horchaka, you know,\" Horchaka continued, with the third person self—referral that seemed to pepper his speech more whenever his popularity ratings dipped for a moment. (The last time he had succeeded in raising his place in his polls again by outlawing smoking in bed, to bipartisan support.) But the Impenetrable Soldier did not seem to know; in fact he seemed to know nothing at all but the art of petting. Beneath his old suit of calm, of course, he was figuring out how best to funnel large sums of money into Horchaka's campaign from groups which Horchaka's chief supporters hated viciously. <br>\
 Victor, heedless of the seriousness demanded by the situation, was whimpering most plaintively, in an attempt to rouse somebody — preferably his owner — into playing ball. He liked being petted well enough, but running and catching small spheres in one's jaws constituted for him a close second to the heights of making sweet poodle love. `,
` The wizened visage of the Truflagus stared out at young Rafe; its spindly branches worked their way towards his mouth as it sighed. Young Rafe, who was terrified, attempted to steer the tenor of his emotions towards gratitude. He hand not been seriously injured yet, fear had not led him to soil his pants: there was plenty of occasion for rejoicing already. But then one of the Truflagus' twigs scratched young Rafe awfully close, on the cheek, to his right eye. With the ensuing red drops, alas, trickled out all of the boy's fine resolve for calm meditativeness. He began to cry.<br>\
 Unbeknownst to young Rafe, old Rafe was just around the corner: jaunty and as empty of tears as a lonesome sexagenarian can be. For he had just had a coffee, you see, and had decided, on the strength of his resulting caffeine rush, to survey the instruments available at the local pawnshop. Never in his life had old Rafe heard of Truflaguses, and the great—nephew named in his honour was scarcely better known to him. He had been born in December, though not on Christmas. At some point as a babe he had been much enamoured of walnuts and cold chicken — this old Rafe remembered because, bored as he'd been by his sister Lucille's endless reports about her new grandson, he had had but a light tea of bread and jam that day, and so the mere mention of walnuts and cold chicken had proved endlessly appealing. `,
` Hinfrot the Elephant was discombobulated by the recent pace of work. e was not alone: Schlemnik the Mink's whiskers had nearly come undone over this final quarter of card—creation management. Except Schlemnik's anxiety pervaded him just about as deeply all year round: it was the existential dread of a creature whose forefathers had all been skinned (and _then_ murdered) in the interest of making rich ladies coats. Schlemnik couldn't even stand to be around little poor girls as a result. \"What if this Daisy should grow up to marry a Duke?\", he had whispered to Hinfrot, horror—struck, one day at a Human Park. The visit had been Hinfrot's sole attempt at exposure therapy for his dear friend. \"What then?\", the mink had continued to whisper, eyes bulging, pointing at a fair little creature with long fingers and auburn hair. Eventually his eyes rolled back into his forehead, and thus Schlenmik had fainted.<br>\
 It had been some time after Father's Day then. (Hinfrot habitually thought of years as increments between holidays, a habit which had crept up on him unawares over his first two or three years of employment.) Schlemnik, himself a father of three in spite of his animating spirit of doom and gloom, had left his children without feed for about four weeks following that stint with Daisy. The Beleaguered Mustelid Treatment Haven was an appallingly expensive recovery center, as indeed they all were, but the security guards who'd come to Hinfrot's aid when the weak mink couldn't be roused had insisted on his being interned there. \"We here at Human Park have the utmost solicitude for our visitors,\" a hippo called WELCOME,! TINA, according to her name tag, had notified Hinfrot as the guards, both monkeys (YOU'RE SAFE WITH US! TIM and YOU'RE SAFE WITH US! TURNER), had loaded Schlemnik onto a stretcher. `,
` \"Have you heard the Orgolot sing, lately?\", inquired the blind man of Petra. Petra had to admit, shame—facedly, that no, she had not. The old gentleman smiled fondly and leaned forwards on his cane, getting so close to the birthday cake on the table that some blue icing smeared his remarkably well—shaved chin. Smoothly wiping the intrusion of delicacy away, he whispered to Petra that it was quite all right for it to be so, and that he had not heard the Orgolot much of late, either.<br>\
 This simple kindness made Petra cry. For years she had pursued the Orgolot with the utmost assiduity, going so far as to make charts tracking its peregrinations and to learn perfectly to imitate the female of that species' mating call. But last year her money, prize money from a lottery she had won on the cusp of adulthood, had run out, and suddenly it was no easy task to estimate the trajectory of the Orgolot from midnight till noon based on the weather and the alignment of the stars. Quite rapidly she had been forced to ply a craft for her living: the ancient art of bloodletting. And the kind permission she had obtained from the Duke of Noxborough for further study of Orgolot reproduction and communication at the New—Lydian Orgolot Sanctuary had been revoked as soon as her new necessity for paid work was heard of. It was doubtful whether Petra should be able to obtain even permissions without kindness, in future, from museums and such. `,
` \"My throat hurts,\" Lanagine whispered, face brimming with sadness for her condition. \"It hurts to swallow. It was torture eating grapes.\"<br>\
 Lamorey raised an eyebrow at his daughter. Although the piles of books on his desk were significant, he could still see his youngest offspring's pale, malnourished face. It couldn't hurt her, surely, to try eating something more substantial than grapes. But Lamorey had too much Tact to pronounce such a statement. Instead he demonstratively placed _Life and Times of Lord Friedrich_ between himself and the earnest, sick girl. \"I don't want to join the ranks of tortured throat—havers,\" Lamorey confessed from behind his barrier. \"Begone to a house of wellness; just leave us poor healthy individuals alone!\" Indeed Lamorey's paternal instincts were little likely to rear up either for adult children or for the birds of the sick—bed. And so Lanagine, with disappointment which seemed disproportionate, considering her good prior understanding of her father's moods and interests, sailed down the bannisters and slunk off into the kitchen, where she knew Cook would be liable to produce her a \"Cheer Up!\" omelet. `,
` \"We must prepare for a siege,\" announced Zarputra, cheerfully, \"there's nothing better for it!\" Although the castles and rituals of Zormengasten were a sight less sophisticated — not to mention appealing — that those of her blessed upbringing in Zogneu, still it was a constitutional part of that young queen's character to resist pessimism and to rejoice in the little things, such as the knowledge that her newest pair of shoes would bear, as requested, dozens of the choicest pearls. A siege, she was confident, could be borne in high spirits, as long as they all kept their wits about them and delighted, at night—time, in impromptu bedchamber music performances. Zarputra, in spite of demeaning rumors regarding her skill with the lute, plucked hers with a deft hand, and even the ambassador of the foreign country uninterested in accepting her claim of rightful heir to its throne had to concede, if not that she played well, that her fingers were beautiful. `,
` \"And they say,\" whispered the rabbit — her eyes open wide with excitement, her nose, irrepressibly, twitching a little —, \"that each Christmas he sends his favourites the most delectable extant pistachio toffee butternut pie!\" This surprising combination of filling ingredients served as the Rabbit's crescendo, and it was in an excited frenzy that she gave an interstitial chomp to the heirloom carrot in her left front paw. The Bear, impassive, could have been a statue; except he smelled too much of meat, and gave too much impression of aliveness. Perhaps the trick was in his eyes, which conveyed something of laughter. <br>\
 Just then the Fox joined them under the oak tree, bearing the truce gift of a pinecone. \"I'm sorry I don't have a pie for you,\" she chuckled, sounding in fact rather pleased, \"but do accept a humble pinecone, I prithee.\" The Rabbit's fur stood on end — she could feel the untrustworthiness of this red beast, knew that the visitor craved something she herself would be most sorry to see disappear — as she smiled and accepted the gift, knowing that every gesture was binding her in more deep. But what was she to do? For she had thrown in her lot with the Bear's, and the Fox and he were at present business associates.<br>\
 It had begun a week or so ago, the talk of burning the forest down. She had gasped to hear it, at first; surely it was a joke, poor, like the one the Bear had made about her dying based on his reading of the tea—leaves. But the Fox's calculations were no hollow provocation: they showed an intimate knowledge of physics and, more specifically, everything relevant to the use of gunpowder. Initially the Bear had wanted to send `,
` It was quite early in the morning, at a time when most grown men had already headed out for work and others were directing themselves towards their childcare solutions, that Sir Travis found a strange man's cologne permeating, of yesterday, his wife's brassiere.<br>\
 Now, Sir Travis did not jump to conclusions, in spite of his status as a well—to—do man with many underlings in his employ and a slightly higher than average amount of testosterone circulating through his body. First, rather, he wondered whether some chap had had the immense good fortune to clamber up into his bedchamber and rifle through Lady Travis’ underthings without being intercepted either by a sophisticated camera surveillance system, one of three security guards, or the Travises themselves: for they spent a good amount of time in bed even when they weren’t asleep.<br>\
 `
]
  let curTale = Math.floor(Math.random() * tales.length);
  let continueText = tales[curTale];
  

let orbWorker;
let orbSizeM = 1; //size modifier
function startOrbCanvas(width, height) {
  const canvas = document.getElementById('canvas');
  if (!canvas.transferControlToOffscreen) {
    console.warn('OffscreenCanvas not supported.');
    return;
  }
    orbSizeM = Math.min(document.body.clientWidth, document.body.clientHeight);

  const resizeHandler = () => {
    const canvas = document.getElementById('canvas');
    const sizeFactor = Math.min(document.body.clientWidth, document.body.clientHeight) / orbSizeM;
    orbSizeM = Math.min(document.body.clientWidth, document.body.clientHeight);
    const size = Math.min(canvas.clientWidth, canvas.clientHeight) * sizeFactor;
    //const newHeight = Math.min(canvas.clientWidth, canvas.clientHeight) * sizeFactor;
    
  canvas.style.width = `${size}px`;
  canvas.style.height = `${size}px`;

    orbWorker.postMessage({
      type: 'resize',
      width: size,
      height: size,
      pixelRatio: window.devicePixelRatio
    });
  };

  // Terminate previous worker if it exists
  if (orbWorker) {
    orbWorker.terminate();
    orbWorker = null;
  } else {
    window.addEventListener('resize', resizeHandler);
  }

  const offscreen = canvas.transferControlToOffscreen();
  orbWorker = new Worker('orbWorker.js');
  orbSizeM = Math.min(document.body.clientWidth, document.body.clientHeight);
  canvas.style.width = `${width}px`;
  canvas.style.height = `${height}px`;

  //console.log("PR", window.devicePixelRatio)
  orbWorker.postMessage({
    type: 'init',
    canvas: offscreen,
    width,
    height,
    pixelRatio: window.devicePixelRatio
  }, [offscreen]);

  

  // Initial call for responsiveness
  

}




  function renderMainUI(preview) {
    document.body.innerHTML = `
      <div class="square-container">
        <div class="background"></div>
        <div class="wizard-container">
          <img src="assets/img/webp/wizard.webp" class="wizard-body" />
          <div class="wizard-hands" style="position:absolute; width: 100%; height: 100%;">
            <canvas id="canvas" width=1200 height=800 style="border:0px solid #d3d3d3; position: absolute; top: 53.8%; left: 74.2%; z-index: 0; opacity: 95%;">
            Your browser does not support the HTML5 canvas tag.</canvas>
            <img src="assets/img/webp/wizard_hands_r.webp" style="position:absolute; width: 110%; height: 115%;" />
          </div>
          <img src="assets/img/webp/wizard_hands_l.webp" class="wizard-finger" style="position:absolute; width: 110%; height: 115%;" />
        </div>
        <div class="text-box">
          <div class="text-box-background"></div>
          <div class="text-container">
          <?php if ($formSubmitted): ?>
          <p id="wizard-text" style="position: relative; font-size: 0.85rem;">You have been added to the list, dear <?=htmlspecialchars($name) ?> — we shall be in touch as soon as my great work is in its final form!</p>
          <?php else: ?>
          <p id="wizard-text" style="position: relative; width: 100%; height: 100%; font-size: 0.88rem;">Oh goodness, I'm not quite ready to welcome visitors yet! Do join my <span id="mail" style="color: blue; text-decoration: underline; cursor: pointer;">mailing list</span> — I'll invite you over soon!</p>
          <?php endif; ?>
          </div>
        </div>
        <img src="assets/img/webp/text_next.webp" id="nextBtn" style="position: absolute; width: 8%; top: 79%; left: 83%; cursor: pointer; visibility: hidden; z-index: 5;" />
        
        <div class="options-bar">
          <div class="options-buttons">
            <div class="button" id="option1" style="background-image: url('assets/img/webp/toolbar_frame.webp');">
            <img id="highlight1" src='assets/img/webp/highlight.webp' style="position: absolute; top: -50%; left: -50%; bottom: 0; z-index: -1; visibility: hidden; width: 200%;"/>
            </div>
            <div class="button" id="option2" style="background-image: url('assets/img/webp/toolbar_helpbtn.webp');">
            <img id="highlight2" src='assets/img/webp/highlight.webp' style="position: absolute; top: -50%; left: -50%; bottom: 0; z-index: -1; visibility: hidden; width: 200%;"/>
            </div>
            <div class="button" id="option3" style="background-image: url('assets/img/webp/toolbar_quillbtn.webp');">
            <img id="highlight3" src='assets/img/webp/highlight.webp' style="position: absolute; left: -40%; bottom: -33%; z-index: -1; visibility: hidden; width: 150%;"/>
            </div>
            <div class="button" id="option4" style="background-image: url('assets/img/webp/toolbar_book.webp');">
            <img id="highlight4" src='assets/img/webp/highlight.webp' style="position: absolute; top: -50%; left: -50%; bottom: 0; z-index: -1; visibility: hidden; width: 200%;"/>
            </div>
            <div class="button" id="option5" style="background-image: url('assets/img/webp/toolbar_menubtn.webp');">
            <img id="highlight5" src='assets/img/webp/highlight.webp' style="position: absolute; top: -50%; left: -50%; bottom: 0; z-index: -1; visibility: hidden; width: 200%;"/>
            </div>
            <div class="button" id="option6" style="background-image: url('assets/img/webp/toolbar_searchbtn.webp');">
            <img id="highlight6" src='assets/img/webp/highlight.webp' style="position: absolute; left: -75%; bottom: -50%; z-index: -1; visibility: hidden; width: 200%;"/>
            </div>
          </div>
          <div class="options-background"></div>
        </div>
      </div>
    `;
    const size = Math.min(document.body.clientWidth, document.body.clientHeight) * 0.162;
    startOrbCanvas(size, size);
    // Re-attach button handlers after rendering
    const text = document.getElementById("wizard-text");
    const page = document.body;

    localStorage.removeItem("revisit");
    const revisit = localStorage.getItem("revisit");
    if (revisit !== "true") {
      localStorage.setItem("revisit", "true");
    } else {
      text.innerHTML = `Welcome, welcome back!<br>Would you like to <span id="read" style="color: blue; text-decoration: underline; cursor: pointer;">read</span>? <br>Have you a <span id="purchase" style="color: blue; text-decoration: underline; cursor: pointer;">purchase</span> in mind?`
    }

      if(preview) text.innerHTML = `Dear visitor, I must confess that I cannot accept Commissions just yet! Do join my <span id="mail" style="color: blue; text-decoration: underline; cursor: pointer;">mailing list</span> to be kept abreast of further developments.`
      
    // let mailBtn = document.getElementById("mail");
    // if(mailBtn){
    //   mailBtn.onclick = () => {
    //     renderMail();
    //   };
    // }
    let readBtn = document.getElementById("read");
    if(readBtn){
      readBtn.onclick = () => {
        text.innerHTML = `The eternal reader, the eternal learner!<br>Shall I direct you towards my fantastical <span id="readGo" style="color: blue; text-decoration: underline; cursor: pointer;">scrolls</span>? <br>or my cousin Nimue's <span id="purchaseGo" style="color: blue; text-decoration: underline; cursor: pointer;">ballads</span>?`
        let readGo = document.getElementById("readGo");
        readGo.onclick = () => {
          renderScrolls();
        };
        let purchaseGo = document.getElementById("purchaseGo");
        purchaseGo.onclick = () => {
          renderSong();
        };
      };
    }
    let purchaseBtn = document.getElementById("purchase");
    if(purchaseBtn){
      purchaseBtn.onclick = () => {
        text.innerHTML = `How fortunate!<br>Shall you commission the expansion of a <span id="readGo" style="color: blue; text-decoration: underline; cursor: pointer;">scroll</span>? <br>or an ornate copy of a <span id="purchaseGo" style="color: blue; text-decoration: underline; cursor: pointer;">ballad</span>?`      
        let readGo = document.getElementById("readGo");
        readGo.onclick = () => {
          renderScrolls();
        };
        let purchaseGo = document.getElementById("purchaseGo");
        purchaseGo.onclick = () => {
          renderSong();
        };
      };
    }
    mailBtn = document.getElementById("mail");
    mailBtn.onclick = () => {
      renderMail();
    };

    let animating = false;

    for(let i=0; i<6; i++){
      const button = document.getElementById(`option${i+1}`);
      const buttonHL = document.getElementById(`highlight${i+1}`);
      button.onmouseover = () => {
        buttonHL.style.visibility = "visible";
      }
      button.onmouseout = () => {
        buttonHL.style.visibility = "hidden";
      }
      button.onclick = () => {
        
      //   console.log("LOG");
        // page.innerHTML = ``;
        if (i == 0){
          //text.innerHTML = `Do you wish to be kept abreast of the <span id="mail" style="color: blue; text-decoration: underline; cursor: pointer;">Wizard's Good News</span>?`
          // text.innerHTML = `Oh! I'm afraid you shall have to try that later! Meanwhile, my <span id="mail" style="color: blue; text-decoration: underline; cursor: pointer;">mailing list</span> awaits ye!`
          // mailBtn = document.getElementById("mail");
          // mailBtn.onclick = () => {
          //   renderMail();
          // };
          // nextBtn = document.getElementById("nextBtn");
          // nextBtn.style.visibility = "hidden";
          renderSheherezade();
        } else if(i == 1){
          text.style = "font-size: 0.85rem;"
          text.innerHTML = `My faithful House Mouse said that there were simply too many <span id="readGo" style="color: blue; text-decoration: underline; cursor: pointer;">scrolls</span>  around here, and that curious readers could surely help to make them into <span id="purchaseGo" style="color: blue; text-decoration: underline; cursor: pointer;">books</span>!`
          let readGo = document.getElementById("readGo");
          readGo.onclick = () => {
            renderScrolls();
          };
          let purchaseGo = document.getElementById("purchaseGo");
          purchaseGo.onclick = () => {
            renderCommissions();
          }; 
          nextBtn = document.getElementById("nextBtn");
          nextBtn.style.visibility = "visible";
          let jump = false;
          nextBtn.style.transform = `rotateZ(7deg)`;
          function anim(){
            if(animating){
              setTimeout(function() {
              const rot = jump ? 7 : 0;
              nextBtn.style.transform = `rotateZ(${rot}deg)`;
              jump = !jump;
              anim();
              }, 666)
            };
          }
          if(!animating){
            animating = true;
            anim();
          }
          
          nextBtn.onclick = () => {
            nextBtn.style.visibility = "hidden";
            animating = false;
            text.innerHTML = `The <span id="songGo" style="color: blue; text-decoration: underline; cursor: pointer;">Songbook</span> was made by my cousin Nimue. I'm displaying it as a favour, but her songs make rather pleasant—looking posters, don't you think?`
          
            let songGo = document.getElementById("songGo");
            songGo.onclick = () => {
              renderSong();
            }; 
          }; 

        } else if(i == 2){
          renderCommissions();
          // renderMainUI();
        } else if(i == 3){
          renderSong();
        } else if(i == 4){
          continueText = tales[curTale];
          renderScrolls();
          
        } else if(i == 5){
          renderSearch();
        }
        
        
      };
    }
  }

  // let shortest = 999999;
  // let curshawty = -1;

  // for(let i=0; i<tales.length; i++){
  //   if(tales[i].length < shortest && tales[i].length > 156){
  //     curshawty = i;
  //     shortest = tales[i].length
  //     //console.log()
  //   }
  // }
  //   console.log(shortest, tales[curshawty])

  // Initial render
  renderMainUI();
  // renderMail();
  // renderScrolls();
    // renderSong();
    // renderSearch();
    // renderSearchResults("cheese");
  function renderScrolls(scroll) {
    const scrn = Math.min(document.body.clientWidth, document.body.clientHeight) + "px";
    document.body.innerHTML = `
      <div class="square-container">
        <div class="background"></div>
        <div class="crystalbackground">
        <div style="position:absolute; width: 100%; height: 100%;">
            <canvas id="canvas" width="1200px" height="800px" style="border:0px solid #d3d3d3; position: absolute; top: -5%; left: -10%; z-index: -2; opacity: 95%;">
            Your browser does not support the HTML5 canvas tag.</canvas>
        </div>
        <img src="assets/img/webp/scroll.webp" alt="scroll" style="max-width: 100%; height: 100%; width: 100%; "/>
        <p id="textContent" style='text-align: justify;  overflow-wrap: break-word; hyphens: auto; hyphenate-character: "—"; color: #151D26; opacity: 0.9;  position: absolute; top: 17%; left:15%; height: 55%; width: 70%; overflow: hidden; z-index: 4'>EXAMPLE TEXT<p/>
        <p id="sizer" style='text-align: justify;  overflow-wrap: break-word; hyphens: auto; hyphenate-character: "—"; width: 70%; position: absolute; visibility: hidden; white-space: normal;'><p/>
        <img src="assets/img/webp/scroll_mouse.webp" alt="mouse"  style="position: absolute; top: 8%; left:0px; max-height: 100%; max-width: 100%; height: 100%; width: 100%;  z-index: 2"/>
        <img src="assets/img/webp/scroll_continuebtn.webp" alt="continue"  id="buttonCont" style="cursor: pointer; position: absolute; top: 80%; left: 11%; max-width: 75%; width: 25%; z-index: 3"/>
        <img src="assets/img/webp/scroll_changebtn.webp" alt="change"  id="buttonChng"  style="cursor: pointer; position: absolute; top: 80%; left: 65%; max-width: 75%; width: 25%; z-index: 3"/>
        <img src="assets/img/webp/scroll_quill.webp" alt="commission" id="buttonCommission" style="cursor: pointer; position: absolute; top: 80%; left: 46%; max-width: 75%; width: 20%; z-index: 3"/>
        <img src="assets/img/webp/button_back.webp" alt="back" id="buttonBack"  class="buttonBack"  style="cursor: pointer; position: absolute; top: 2%; left: 2%; max-width: 100%; width: 7%; z-index: 4"/>
        </div>
        </div>
      </div>
    `
    const size = Math.min(document.body.clientWidth, document.body.clientHeight) * 1.2;
    startOrbCanvas(size, size);
      //const canvas = document.getElementById('canvas');
      //renderOrb(document.body.clientWidth * 0.5,document.body.clientHeight * 0.5);
      const buttonCont = document.getElementById(`buttonCont`);
      buttonCont.onclick = () => {
        if(content.innerHTML.length == 0) continueText = tales[curTale];
        // renderScrolls();
        findCutIndex(content, sizer, continueText);
      };
      const button = document.getElementById(`buttonChng`);
      buttonChng.onclick = () => {
        const old = curTale;
        curTale = Math.floor(Math.random() * tales.length);
        console.log(curTale)
        if (curTale == old) curTale = Math.floor(Math.random() * tales.length);
        continueText = tales[curTale];
        // renderScrolls();
        findCutIndex(content, sizer, continueText);
      };
      const backBtn = document.getElementById(`buttonBack`);
      backBtn.onclick = () => {
        renderMainUI();
      };

      const commBtn = document.getElementById(`buttonCommission`);
      commBtn.onclick = () => {
        renderCommissions(curTale);
      };

    const content = document.getElementById("textContent");
    const sizer = document.getElementById("sizer");


    // Call the function and update the text
    findCutIndex(content, sizer, continueText);

    
  }
    
  function findCutIndex(content, sizer, fullText) {
    content.innerHTML = fullText;
    sizer.innerHTML = fullText;

    const originalHeight = content.clientHeight;
    const words = fullText.split(" ");

    let cutIndex = -1;
    let currentText = "";

    for (let i = 0; i < words.length; i++) {
        const testText = words.slice(0, i + 1).join(" ");
        sizer.innerHTML = testText;
        //console.log("Loop:", i, sizer.clientHeight, originalHeight, testText)
        
        if (sizer.clientHeight > originalHeight) {
          //console.log("Break", i, testText, currentText.length)
            break;
        }

        currentText = testText;
        cutIndex = currentText.length;
    }

    // Apply the truncated text
    content.innerHTML = currentText;

    if (cutIndex !== -1) {
        continueText = continueText.slice(cutIndex).trim();
    }
    // Return the index for slicing the remaining text
    return cutIndex;
  }
  function renderCrystal() {
  
    const scrn = Math.min(document.body.clientWidth, document.body.clientHeight) + "px";
      
    document.body.innerHTML = `
    <div class="square-container">
        <div class="background"></div>
        <div class="crystalbackground">
        <div style="position:absolute; width: 100%; height: 100%;">
            <canvas id="canvas" width="1200px" height="800px" style="border:0px solid #d3d3d3; position: absolute; top: -5%; left: -10%; z-index: -2; opacity: 95%;">
            Your browser does not support the HTML5 canvas tag.</canvas>
        </div>
        </div>
        </div>
        `
    const size = Math.min(document.body.clientWidth, document.body.clientHeight) * 1.2;
    startOrbCanvas(size, size);
  }
  
  //renderCrystal();

  function renderSearch(scroll) {

    const scrn = Math.min(document.body.clientWidth, document.body.clientHeight) + "px";
    document.body.innerHTML = `
      <div class="square-container">
        <div class="background"></div>
          <div class="crystalbackground" style="max-width: 100%; height: 100%; width: 100%; ">
          <div style="position:absolute; width: 100%; height: 100%;">
              <canvas id="canvas" width="1200px" height="800px" style="border:0px solid #d3d3d3; position: absolute; top: -5%; left: -10%; z-index: -2; opacity: 95%;">
              Your browser does not support the HTML5 canvas tag.</canvas>
          </div>
          <img src="assets/img/webp/search_mg.webp" alt="searching glass" style="max-width: 100%; height: 100%; width: 100%; "/>
          <span style="font-weight: 1000; font-size: 2.2rem; color: #454D66; position: absolute; top: 17%; left:30%; max-height: 100%; max-width: 100%; height: 100%; width: 100%;  z-index: 2">Which word</span>
          <span style="font-weight: 1000; font-size: 1.75rem; color: #454D66; position: absolute; top: 26.4%; left:41%; max-height: 100%; max-width: 100%; height: 100%; width: 100%;  z-index: 2">do you</span>
          <span style="font-weight: 1000; font-size: 1.75rem; color: #454D66; position: absolute; top: 33.6%; left:37%; max-height: 100%; max-width: 100%; height: 100%; width: 100%;  z-index: 2">search for?</span>
          <span id="submit" style="font-size: 0.67rem; color: #454D66; position: absolute; top: 60%; left:43.8%; height: 10%; width: 10%; z-index: 2; padding: 2%; cursor: pointer;">SEARCH</span>
          <input type="text" id="search" style="font-size: 1.5rem; color: #2F6099; position: absolute; top: 45%; left:50%; transform: translate(-50%, 0%); height: 10%; width: 30%; z-index: 2; background: #88888844; border: solid 1px #2f60996b; font-family: Courier New; text-align: center"; value="Cheese"></input>
          <img src="assets/img/webp/button_back.webp" alt="back" id="buttonBack"  class="buttonBack"  style="cursor: pointer; position: absolute; top: 2%; left: 2%; max-width: 100%; width: 7%; z-index: 3"/>
          </div>
        </div>
      </div>
    `
    
    const size = Math.min(document.body.clientWidth, document.body.clientHeight) * 1.2;
    startOrbCanvas(size, size);
      //renderOrb(document.body.clientWidth * 2,document.body.clientHeight * 2);
      const search = document.getElementById(`search`);
      if(scroll) search.value = scroll;
      const submit = document.getElementById(`submit`);
      submit.onclick = () => {
        renderSearchResults(search.value)
      };
      submit.addEventListener('mouseenter', () => {
        submit.style.color = "#ffffff";
      });
      submit.addEventListener('mouseleave', () => {
        submit.style.color = "#454D66";
      });
      
      const backBtn = document.getElementById(`buttonBack`);
      backBtn.onclick = () => {
        renderMainUI();
      };

  }

  function renderSearchResults(scroll) {
    const scrn = Math.min(document.body.clientWidth, document.body.clientHeight) + "px";
    document.body.innerHTML = `
      <div class="square-container">
        <div class="background"></div>
        <div class="crystalbackground">
        <div style="position:absolute; width: 100%; height: 100%;">
            <canvas id="canvas" width="1200px" height="800px" style="border:0px solid #d3d3d3; position: absolute; top: -5%; left: -10%; z-index: -2; opacity: 95%;">
            Your browser does not support the HTML5 canvas tag.</canvas>
        </div>
          <img src="assets/img/webp/search_resultsBox.webp" alt="frame" style="max-width: 100%; height: 100%; width: 100%;  z-index: 1; position: absolute;"/>
          <p id="resultsInfo" style="max-width: 95%; color: white; z-index: 2; position: absolute; top: 3%; left: 15%; font-size: 2.3rem;">There are <span style="font-size: 2.5rem">16</span> results:</p>
          
          <img src="assets/img/webp/search_resultGlass.webp" alt="searching glass" style="max-width: 100%; height: 100%; width: 100%;  z-index: 2; position: absolute; pointer-events: none;"/>
          <img src="assets/img/webp/search_resultFrame.webp" alt="frame" style="max-width: 100%; height: 100%; width: 100%;  z-index: 2; position: absolute;pointer-events: none;"/>
          <p id="resultsText" style="max-width: 75%; width: 60%; height: 42%; padding: 10px; color: #454D66; z-index: 2; pointer-events: none; position: absolute; top: 28%; left: 19%; font-size: 1.5rem;">... Try again!</p>
  
          <img src="assets/img/webp/search_readOnbtn.webp" alt="continue"  id="buttonCont" style="cursor: pointer; position: absolute; top: 78.5%; left: 32%; max-width: 75%; width: 32.5%; z-index: 1"/>
          <img src="assets/img/webp/button_back.webp" alt="back" id="buttonBack"  class="buttonBack"  style="cursor: pointer; position: absolute; top: 2%; left: 2%; max-width: 100%; width: 7%; z-index: 3"/>
        
          <span id="next" style="position: absolute; top: 47%; left:85%; width: 15%; height: 15%; z-index: 2; cursor: pointer;"></span>
          <span id="prev" style="position: absolute; top: 47%; left:0px; width: 15%; height: 15%; z-index: 2; cursor: pointer;"></span>
       </div>
        </div>
      </div>
    `
    console.log(scroll);
      
    const size = Math.min(document.body.clientWidth, document.body.clientHeight) * 1.2;
    startOrbCanvas(size, size);
      //renderOrb(document.body.clientWidth * 2,document.body.clientHeight * 2);
      let snippet = 0;
      const results = searchGetWordMatches(scroll, tales);

      const info = document.getElementById(`resultsInfo`);
      info.innerHTML = `There are <span style="font-size: 3rem">${results.length}</span> results:`
      if (results.length > 0){
        setText();
        const contBtn = document.getElementById(`buttonCont`);
        contBtn.onclick = () => {
          curTale = results[snippet];
          continueText = tales[curTale];
          renderScrolls();
        };

        const nextBtn = document.getElementById(`next`);
        nextBtn.onclick = () => {
          if (results.length > 1){
            snippet++
            if (snippet > results.length - 1) snippet = 0;
            console.log(snippet);
            setText();
          }
        };
        const prevBtn = document.getElementById(`prev`);
        prevBtn.onclick = () => {
          if (results.length > 1){
            snippet--
            if (snippet < 0) snippet = results.length - 1;
            console.log(snippet);
            setText();
          }
        };
      }

      const backBtn = document.getElementById(`buttonBack`);
      backBtn.onclick = () => {
        renderSearch(scroll);
      };
      function setText() {
          const matchedIndex = results[snippet];
          const fullText = tales[matchedIndex];

          // Clean and split into words
          const words = fullText.split(/\s+/);
          const lowerScroll = scroll.toLowerCase();

          // Find the index of the word match (case-insensitive)
          let matchIndex = words.findIndex(word => word.toLowerCase().includes(lowerScroll));
          if (matchIndex === -1) matchIndex = 0; // Fallback

          // Define the window size
          const before = Math.max(0, matchIndex - 8);
          const after = Math.min(words.length, matchIndex + 9); // +11 to include matched word

          const snippetWordsB = words.slice(before, matchIndex).join(" ");
          const snippetWordsA = words.slice(matchIndex + 1, after).join(" ");

          // Highlight only the matching part of the word
          const originalWord = words[matchIndex];
          const lowerWord = originalWord.toLowerCase();
          const matchPos = lowerWord.indexOf(lowerScroll);

          let highlightedWord;
          if (matchPos !== -1) {
              highlightedWord =
                  originalWord.substring(0, matchPos) +
                  `<span style="color: #D4BE03; font-weight: bold;">` +
                  originalWord.substring(matchPos, matchPos + lowerScroll.length) +
                  `</span>` +
                  originalWord.substring(matchPos + lowerScroll.length);
          } else {
              highlightedWord = originalWord; // Fallback, shouldn't happen
          }

          // Display in UI
          const text = document.getElementById(`resultsText`);
          text.innerHTML = "..." + snippetWordsB + " " + highlightedWord + " " + snippetWordsA + "...";
      }

  }

function searchGetWordMatches(word, stringArray) {
    const lowerWord = word.toLowerCase();

    return stringArray
        .map((text, index) => ({ text: text.toLowerCase(), index }))
        .filter(item => item.text.includes(lowerWord))
        .map(item => item.index);
}



  function renderSong(song) {
    const scrn = Math.min(document.body.clientWidth, document.body.clientHeight) + "px";
    document.body.innerHTML = `
      <div class="square-container">
        <div class="background"></div>
          <div class="crystalbackground">
            <div style="position:absolute; width: 100%; height: 100%;">
                <canvas id="canvas" width="1200px" height="800px" style="border:0px solid #d3d3d3; position: absolute; top: -5%; left: -10%; z-index: -2; opacity: 95%;">
                Your browser does not support the HTML5 canvas tag.</canvas>
            </div>
            <img id="i2" style="position: absolute; z-index: 5; display: none; width: 59%; height: 59%;"/>
            <div id="drag-right" style="position: absolute; top: 12%; left: 48%;">
                <canvas id="c2" style="position: absolute; z-index: 5; width: 46%; cursor: zoom-in;"></canvas>
            </div>
            <img id="i" style="position: absolute; z-index: 5; display: none; width: 59%; height: 59%;"/>
            <div id="drag-wrapper" style="position: absolute; top: 12%; left: 8.5%;">
                <canvas id="c"style="position: absolute; z-index: 5; width: 46%; cursor: zoom-in;"></canvas>
            </div>
            <img id="prev-image" style="position: absolute; z-index: 5; display: none; width: 59%; height: 59%;"/>
            <img src="assets/img/webp/songbook_open.webp" alt="songbook"  style="position: absolute; max-width: 100%; max-height: 100%; width: 100%; height: 100%; pointer-events: none; "/>
            <img src="assets/img/webp/songbook_flip_s.webp" alt="flip" id="flipL" style="position: absolute; top: 56.5%; left: 12.3%; z-index: 6; display: none; width: 13%"/>
            <img src="assets/img/webp/songbook_flip_s.webp" alt="flip" id="flipR" style="position: absolute; top: 57%; left: 74.5%; transform: scale(-1, 1); z-index: 6; display: none;  width: 13%"/>
            <p id="flip_zoneL" style="cursor: pointer; position: absolute; top: 50%; left: 10%; z-index: 6; width: 150px; height: 150px; border:"></p>
            <p id="flip_zoneR" style="cursor: pointer; position: absolute; top: 50%; left: 75%; z-index: 6; width: 150px; height: 150px; border:"></p>
            <img src="assets/img/webp/button_back.webp" alt="back" id="buttonBack"  class="buttonBack"  style="cursor: pointer; position: absolute; top: 2%; left: 2%; max-width: 100%; width: 7%; z-index: 2 "/>
            <div>
            <img src="assets/img/webp/purchase_textmouse.webp" style="position: absolute; top: 0%; left:0px; max-height: 100%; max-width: 100%; width: 100%; height: 100%; z-index: 1; pointer-events: none; "/>
              <div style="position: absolute; left: 28%; top: 81%; z-index: 3; width: 59%;" class="text-container">
              <p style="font-size: 0.85rem;">I've assembled this piece of work for my cousin Nimue, who writes the most <span style="font-style: italic;">interesting</span> songs!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    `
    const size = Math.min(document.body.clientWidth, document.body.clientHeight) * 1.2;
    startOrbCanvas(size, size);
      //renderOrb(document.body.clientWidth * 2,document.body.clientHeight * 2);
      ////renderOrb(document.body.clientWidth * 2,document.body.clientHeight * 2);
      // const pageLeft = document.getElementById(`pageLeft`);
      // pageLeft.onclick = () => {
      //   renderBallad("ballad_seven");
      // };
      // const pageRight = document.getElementById(`pageRight`);
      // pageRight.onclick = () => {
      //   renderBallad("ballad_sftsk");
      // };

      
    //http://mike.teczno.com/notes/canvas-warp.html
    //http://s3.amazonaws.com/canvas-warp/2009-11-01/index.html
    const utils = {

        rndInt(max, override) {
            //if(override !== undefined) { return override; }
            return Math.round(Math.random() * max);
        },
        
        /**
         * https://en.wikipedia.org/wiki/Incircle_and_excircles_of_a_triangle
         * https://math.stackexchange.com/questions/1413372/find-cartesian-coordinates-of-the-incenter
         * https://www.mathopenref.com/coordincenter.html
         */
        calcIncircle(A, B, C) {
            function lineLen(p1, p2) {
                const dx = p2[0] - p1[0],
                      dy = p2[1] - p1[1];
                return Math.sqrt(dx*dx + dy*dy);
            }
            
            //Side lengths, perimiter p and semiperimiter s:
            const a = lineLen(B, C),
                  b = lineLen(C, A),
                  c = lineLen(A, B),
                  p = (a + b + c),
                  s = p/2;
            
            //Heron's formula
            //https://www.wikihow.com/Calculate-the-Area-of-a-Triangle#Using_Side_Lengths
            const area = Math.sqrt(s * (s-a) * (s-b) * (s-c));
            //Faster(?) alternative:
            //http://geomalgorithms.com/a01-_area.html#Modern-Triangles
            //const area = Math.abs( (B[0]-A[0])*(C[1]-A[1]) - (C[0]-A[0])*(B[1]-A[1]) )/2;

            //Incircle radius r
            //  https://en.wikipedia.org/wiki/Incircle_and_excircles_of_a_triangle#Relation_to_area_of_the_triangle
            //..and center [cx, cy]
            //  https://en.wikipedia.org/wiki/Incircle_and_excircles_of_a_triangle#Cartesian_coordinates
            //  https://www.mathopenref.com/coordincenter.html
            const r = area/s,
                  cx = (a*A[0] + b*B[0] + c*C[0]) / p,
                  cy = (a*A[1] + b*B[1] + c*C[1]) / p;
            return {
                r,
                c: [cx, cy],
            }
        },
        
        /*
         * https://math.stackexchange.com/questions/17561/how-to-shrink-a-triangle
         */
        expandTriangle(A, B, C, amount) {
            const incircle = this.calcIncircle(A, B, C),
                  c = incircle.c,
                  factor = (incircle.r + amount)/(incircle.r);
            
            function extendPoint(p) {
                const dx = p[0] - c[0],
                      dy = p[1] - c[1],
                      x2 = (dx * factor) + c[0],
                      y2 = (dy * factor) + c[1];
                return [x2, y2];
            }
            
            const A2 = extendPoint(A),
                  B2 = extendPoint(B),
                  C2 = extendPoint(C);
            return[A2, B2, C2];
        },

        /**
         *  Solves a system of linear equations.
         *
         *  t1 = (a * r1) + (b + s1) + c
         *  t2 = (a * r2) + (b + s2) + c
         *  t3 = (a * r3) + (b + s3) + c
         *
         *  r1 - t3 are the known values.
         *  a, b, c are the unknowns to be solved.
         *  returns the a, b, c coefficients.
         */
        linearSolution(r1, s1, t1, r2, s2, t2, r3, s3, t3)
        {
            var a = (((t2 - t3) * (s1 - s2)) - ((t1 - t2) * (s2 - s3))) / (((r2 - r3) * (s1 - s2)) - ((r1 - r2) * (s2 - s3)));
            var b = (((t2 - t3) * (r1 - r2)) - ((t1 - t2) * (r2 - r3))) / (((s2 - s3) * (r1 - r2)) - ((s1 - s2) * (r2 - r3)));
            var c = t1 - (r1 * a) - (s1 * b);

            return [a, b, c];
        },

        /**
         *  This draws a triangular area from an image onto a canvas,
         *  similar to how ctx.drawImage() draws a rectangular area from an image onto a canvas.
         *
         *  s1-3 are the corners of the triangular area on the source image, and
         *  d1-3 are the corresponding corners of the area on the destination canvas.
         *
         *  Those corner coordinates ([x, y]) can be given in any order,
         *  just make sure s1 corresponds to d1 and so forth.
         */
        drawImageTriangle(img, ctx, s1, s2, s3, d1, d2, d3) {
            //I assume the "m" is for "magic"...
            const xm = this.linearSolution(s1[0], s1[1], d1[0],  s2[0], s2[1], d2[0],  s3[0], s3[1], d3[0]),
                  ym = this.linearSolution(s1[0], s1[1], d1[1],  s2[0], s2[1], d2[1],  s3[0], s3[1], d3[1]);

            ctx.save();

            ctx.setTransform(xm[0], ym[0], xm[1], ym[1], xm[2], ym[2]);
            ctx.beginPath();
            ctx.moveTo(s1[0], s1[1]);
            ctx.lineTo(s2[0], s2[1]);
            ctx.lineTo(s3[0], s3[1]);
            ctx.closePath();
            //Leaves a faint black (or whatever .fillStyle) border around the drawn triangle
            //  ctx.fill();
            ctx.clip();
            ctx.drawImage(img, 0, 0, img.width, img.height);

            ctx.restore();
            
            return;
            
            // //DEBUG - https://en.wikipedia.org/wiki/Incircle_and_excircles_of_a_triangle
            // const incircle = this.calcIncircle(d1, d2, d3),
            //       c = incircle.c;
            // //console.log(incircle);
            // ctx.beginPath();
            // ctx.arc(c[0], c[1], incircle.r, 0, 2*Math.PI, false);
            // ctx.moveTo(d1[0], d1[1]);
            // ctx.lineTo(d2[0], d2[1]);
            // ctx.lineTo(d3[0], d3[1]);
            // ctx.closePath();
            // //ctx.fillStyle = 'rgba(0,0,0, .3)';
            // //ctx.fill();
            // ctx.lineWidth = 2;
            // ctx.strokeStyle = 'rgba(255,0,0, .4)';
            // ctx.stroke();
            
        },
    };


    const flipR = document.getElementById(`flipR`);
    const flipL = document.getElementById(`flipL`);
    const flipZoneL = document.getElementById(`flip_zoneL`);
    const flipZoneR = document.getElementById(`flip_zoneR`);
  
    const cont = document.querySelector('#drag-wrapper');
    const canv = document.querySelector('#c'),
    ctxL = canv.getContext('2d'),
    img = document.querySelector('#i'); 

    const contR = document.querySelector('#drag-right');
    const canvR = document.querySelector('#c2'),
    ctxR = canvR.getContext('2d'),
    imgR = document.querySelector('#i2'); //new Image(),

    imgPrev = document.querySelector('#prev-image'); 

      flipZoneL.onclick = () => {
        if (animating === false){
          flipL.style.display = "none";
          curBallad = curBallad - 2 < 0 ? ballads.length - 2 : curBallad - 2;
          imgPrev.src = img.src;
          img.width *= 1.695;
          img.height *= 1.695;
          img.src = `assets/img/webp/${ballads[(curBallad)]}.webp`;

          //flipL.style.display = "block";
          requestAnimationFrame((t) => flipFrameL(t, 0));
        }
      };
      flipZoneL.addEventListener('mouseenter', () => {
        flipL.style.display = "block";
      });
      flipZoneL.addEventListener('mouseleave', () => {
        flipL.style.display = "none";
        //flipL.style.display = "none";
      });
      flipZoneR.onclick = () => {
        if (animating === false){
          flipR.style.display = "none";
          curBallad = Math.abs((curBallad + 2) % ballads.length)
          imgPrev.src = imgR.src;
          
          imgR.width *= 1.695;
          imgR.height *= 1.695;
          imgR.src = `assets/img/webp/${ballads[(curBallad+1) % ballads.length]}.webp`;

          //flipL.style.display = "block";
          requestAnimationFrame((t) => flipFrameR(t, 0));
        }
      };
      flipZoneR.addEventListener('mouseenter', () => {
        flipR.style.display = "block";
      });
      flipZoneR.addEventListener('mouseleave', () => {
        flipR.style.display = "none";
        //flipL.style.display = "none";
      });
      

      const backBtn = document.getElementById(`buttonBack`);
      backBtn.onclick = () => {
        renderMainUI();
      };
      

     img.src = `assets/img/webp/${ballads[(curBallad)]}.webp`;
     imgR.src = `assets/img/webp/${ballads[(curBallad+1) % ballads.length]}.webp`;
    //handles = document.querySelectorAll('.drag-handle');

    canv.onclick = () => {
      renderBallad(`${ballads[curBallad]}`)
    };

    canvR.onclick = () => {
      renderBallad(`${ballads[(curBallad + 1) % ballads.length]}`)
    };

    cont.style.position = "relative";
    contR.style.position = "relative";

    let wL, hL;
    let cornersL = [];
    let cornersLMod = [];
    let wR, hR;
    let cornersR = [];
    let cornersRMod = [];
    
    function updateUI(ctx, img, corners, cornersMod, under) {

        function drawTriangle(s1, s2, s3, d1, d2, d3) {
            function movePoint(p, exampleSource, exampleTarget) {
                const dx = exampleTarget[0]/exampleSource[0],
                      dy = exampleTarget[1]/exampleSource[1],
                      p2 = [p[0] * dx, p[1] * dy];
                return p2;
            }
            //Overlap the destination areas a little
            //to avoid hairline cracks when drawing mulitiple connected triangles.
            const [d1x, d2x, d3x] = utils.expandTriangle(d1, d2, d3, .3),
                  [s1x, s2x, s3x] = utils.expandTriangle(s1, s2, s3, .3);
                  //s1x = movePoint(s1, d1, d1x),
                  //s2x = movePoint(s2, d2, d2x),
                  //s3x = movePoint(s3, d3, d3x);
            
            utils.drawImageTriangle(img, ctx,
                                    s1x, s2x, s3x,
                                    d1x, d2x, d3x);
        }


        //here we can draw the page underneath...
        // tag under - do not clearrect - first draw under - no clear anim frames

        if(under){
          ctx.clearRect(0,0, w,h);
        }
        generateTriangles(4, 4, w, h, 0);

        
        function generateTriangles(numCols, numRows, w, h, containerEl) {
            //corners = [];
            //cornersMod = [];
            const dx = w / numCols;
            const dy = h / numRows;


            // Step 1: Generate grid points (corners)
            if(corners.length === 0){
                // Clear old handles if re-generating
                if (containerEl) {
                    containerEl.querySelectorAll('.drag-handle').forEach(el => el.remove());
                }
                for (let row = 0; row <= numRows; row++) {
                    for (let col = 0; col <= numCols; col++) {
                        const x = col * dx;
                        const y = row * dy;
                        corners.push([x, y]);
                        cornersMod.push([x, y]);
                        //cornersMod.push([x + utils.rndInt(100)-50, y + utils.rndInt(100)-50]);

                        // Optionally create draggable handles
                        if (containerEl) {
                            const index = row * (numCols + 1) + col;
                            const handle = document.createElement('div');
                            handle.className = 'drag-handle';
                            handle.dataset.corner = index;
                            handle.textContent = index + 1; // or just index

                            // Position the handle (make sure your container is position: relative)
                            handle.style.position = 'absolute';
                            handle.style.left = `${x}px`;
                            handle.style.top = `${y}px`;

                            containerEl.appendChild(handle);
                        }
                    }
                }
            }

            // // Step 1: Generate grid points (corners)
            // for (let row = 0; row <= numRows; row++) {
            //     for (let col = 0; col <= numCols; col++) {
            //         corners.push([col * dx, row * dy]);
            //     }
            // }

            // Helper to get corner index
            function cornerIndex(col, row) {
                return row * (numCols + 1) + col;
            }

            // Step 2: Loop through each quad and make 2 triangles
            for (let row = 0; row < numRows; row++) {
                for (let col = 0; col < numCols; col++) {
                    const topLeftIdx = cornerIndex(col, row);
                    const topRightIdx = cornerIndex(col + 1, row);
                    const bottomLeftIdx = cornerIndex(col, row + 1);
                    const bottomRightIdx = cornerIndex(col + 1, row + 1);

                    const topLeft = corners[topLeftIdx];
                    const topRight = corners[topRightIdx];
                    const bottomLeft = corners[bottomLeftIdx];
                    const bottomRight = corners[bottomRightIdx];

                    // Triangle 1: top-left, bottom-left, center/bottom-right
                    drawTriangle(topLeft, bottomLeft, bottomRight,
                                cornersMod[topLeftIdx], cornersMod[bottomLeftIdx], cornersMod[bottomRightIdx]);

                    // Triangle 2: top-left, bottom-right, top-right
                    drawTriangle(topLeft, bottomRight, topRight,
                                cornersMod[topLeftIdx], cornersMod[bottomRightIdx], cornersMod[topRightIdx]);
                }
            }
        }

        
        
    function dragTracker({ container, selector, handleOffset = 'center', callback }) {
        const handles = container.querySelectorAll(selector);

        handles.forEach(handle => {
            let offsetX = 0;
            let offsetY = 0;

            handle.addEventListener('mousedown', onMouseDown);

            function onMouseDown(e) {
                //e.preventDefault();

                const rect = handle.getBoundingClientRect();
                // offsetX = e.clientX - rect.left;
                // offsetY = e.clientY - rect.top;

                // if (handleOffset === 'center') {
                //     offsetX = rect.width / 2;
                //     offsetY = rect.height / 2;
                // }

                document.addEventListener('mousemove', onMouseMove);
                document.addEventListener('mouseup', onMouseUp);
            }

            function onMouseMove(e) {
                const parentRect = container.getBoundingClientRect();

                let x = e.clientX - parentRect.left - offsetX;
                let y = e.clientY - parentRect.top - offsetY;


                // Clamp values (optional)
                x = Math.max(0, Math.min(x, parentRect.width));
                y = Math.max(0, Math.min(y, parentRect.height));

                handle.style.left = x + 'px';
                handle.style.top = y + 'px';

                const pos = [ x, y ];
                callback(handle, pos);
            }
            function onMouseUp() {
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);

                const offsets = cornersMod.map((mod, i) => {
                    const orig = corners[i];
                    return [mod[0] - orig[0], mod[1] - orig[1]];
                });

                console.log(JSON.stringify(offsets));

                // Optional: also assign to a global so you can inspect it
                // window.cornersOffset = offsets;
            }
        });

    }

    // dragTracker({
    //     container: document.querySelector('#drag-wrapper'),
    //     selector: '.drag-handle',
    //     handleOffset: 'center',
    //     callback: (box, pos) => {
    //         //console.log("MOVIN", pos, box.dataset.corner)
    //         cornersMod[box.dataset.corner] = pos;
    //         //console.log(cornersMod[box.dataset.corner])
    //         updateUI();
    //     },
    // });

    }

    /*
    Flip page:
    There are 2 canvases, one for each page 
    Whenever the corner is clicked it should init the page flip:
    play anim of cur page -> swap cur page image -> play reversed anim of other page 
    
    curPage = left; +1= right
    Left:
    curPage -2
    prev = imgL; imgL = curPage
    call Right, reverse:
    prev = right; imgR=curPage+1
    */

    // 5x5 test 
    const frame1 = [[64.16667175292969,16.25],[32.66667175292969,42.25],[28.166671752929688,40.25],[17.666671752929688,54.25],[-33.83332824707031,80.25],[53.16667175292969,9.75],[20.666671752929688,-5.25],[16.166671752929688,0.75],[-3.3333282470703125,6.75],[-33.83332824707031,5.75],[46.16667175292969,16.25],[19.666671752929688,-0.75],[13.166671752929688,-1.75],[-4.3333282470703125,12.25],[-41.83332824707031,20.25],[41.16667175292969,3.75],[16.666671752929688,1.75],[6.1666717529296875,-3.25],[3.6666717529296875,0.75],[-40.83332824707031,2.75],[35.16667175292969,-49.75],[8.666671752929688,-39.75],[9.166671752929688,-36.75],[-14.333328247070312,-31.75],[-42.83332824707031,-15.75]];
    const frame2 = [[70.16667175292969,27.25],[42.66667175292969,44.25],[9.166671752929688,46.25],[-3.3333282470703125,50.25],[-33.83332824707031,86.25],[78.16667175292969,28.75],[36.66667175292969,4.75],[16.166671752929688,0.75],[-3.3333282470703125,6.75],[-38.83332824707031,11.75],[77.16667175292969,21.25],[28.666671752929688,-4.75],[13.166671752929688,-1.75],[-4.3333282470703125,12.25],[-41.83332824707031,20.25],[68.16667175292969,12.75],[16.666671752929688,1.75],[6.1666717529296875,-3.25],[3.6666717529296875,0.75],[-40.83332824707031,2.75],[63.16667175292969,-47.75],[8.666671752929688,-39.75],[9.166671752929688,-36.75],[-14.333328247070312,-31.75],[-42.83332824707031,-15.75]];
    const frame3 = [[121.16667175292969,34.25],[77.66667175292969,17.25],[20.166671752929688,12.25],[9.666671752929688,36.25],[-33.83332824707031,88.25],[114.16667175292969,21.75],[59.66667175292969,2.75],[24.166671752929688,-9.25],[-5.3333282470703125,0.75],[-40.83332824707031,9.75],[106.16667175292969,18.25],[50.66667175292969,-4.75],[21.166671752929688,-22.75],[-13.333328247070312,-6.75],[-39.83332824707031,6.25],[103.16667175292969,13.75],[68.66667175292969,-17.25],[15.166671752929688,-31.25],[-13.333328247070312,-22.25],[-41.83332824707031,-3.25],[95.16667175292969,-51.75],[59.66667175292969,-72.75],[17.166671752929688,-76.75],[1.6666717529296875,-56.75],[-40.83332824707031,-16.75]];
    const frame4 = [[228.1666717529297,28.25],[159.6666717529297,0],[97.16667175292969,5.25],[46.66667175292969,33.25],[-37.83332824707031,81.25],[223.1666717529297,-17.25],[154.6666717529297,-43.25],[101.16667175292969,-49.25],[36.66667175292969,-24.25],[-37.83332824707031,11.75],[214.1666717529297,-22.75],[166.6666717529297,-70.75],[118.16667175292969,-62.75],[39.66667175292969,-30.75],[-40.83332824707031,3.25],[214.1666717529297,-50.25],[161.6666717529297,-58.25],[107.16667175292969,-64.25],[36.66667175292969,-44.25],[-39.83332824707031,1.75],[210.1666717529297,-124.75],[151.6666717529297,-115.75],[102.16667175292969,-107.75],[40.66667175292969,-71.75],[-40.83332824707031,-17.75]];
    const frame5 = [[415.1666717529297,0],[307.6666717529297,14.25],[195.1666717529297,32.25],[79.66667175292969,52.25],[-40.83332824707031,83.25],[400.1666717529297,-58.25],[287.6666717529297,-47.25],[182.1666717529297,-31.25],[72.66667175292969,-13.25],[-39.83332824707031,9.75],[400.1666717529297,-65.75],[296.6666717529297,-45.75],[183.1666717529297,-29.75],[68.66667175292969,-16.75],[-46.83332824707031,3.25],[391.1666717529297,-60.25],[282.6666717529297,-49.25],[175.1666717529297,-29.25],[69.66667175292969,-9.25],[-48.83332824707031,14.75],[441.1666717529297,-159.75],[313.6666717529297,-101.75],[194.1666717529297,-72.75],[76.66667175292969,-42.75],[-47.83332824707031,-16.75]];
    const frame6 = [[496.1666717529297,0],[367.6666717529297,0],[228.1666717529297,14.25],[96.66667175292969,39.25],[-42.83332824707031,84.25],[503.1666717529297,-67.25],[365.6666717529297,-50.25],[229.1666717529297,-29.25],[89.66667175292969,-10.25],[-44.83332824707031,12.75],[501.1666717529297,-86.75],[362.6666717529297,-65.75],[226.1666717529297,-39.75],[87.66667175292969,-13.75],[-47.83332824707031,7.25],[496.1666717529297,-102.25],[357.6666717529297,-76.25],[221.1666717529297,-51.25],[83.66667175292969,-22.25],[-48.83332824707031,8.75],[495.1666717529297,-109.75],[357.6666717529297,-81.75],[222.1666717529297,-59.75],[87.66667175292969,-34.75],[-46.83332824707031,-19.75]];


    //Right side
    const frameR1 = [[16.5,83.25],[-22,41.25],[-14.5,40.25],[-59,36.25],[-80.5,25.25],[15.5,33.75],[4,9.75],[-10.5,-0.25],[-26,3.75],[-75.5,17.75],[14.5,16.25],[0,0],[-5.5,-10.75],[-17,-8.75],[-73.5,-3.75],[13.5,2.75],[11,-7.25],[-8.5,-16.25],[-22,-18.25],[-63.5,-10.25],[9.5,-16.75],[18,-34.75],[-0.5,-32.75],[-24,-36.75],[-61.5,-38.75]];
    const frameR2 = [[14.5,83.25],[-30,41.25],[-44.5,43.25],[-59,36.25],[-102.5,42.25],[15.5,33.75],[-6,10.75],[-36.5,5.75],[-51,5.75],[-96.5,20.75],[14.5,16.25],[-5,-2.75],[-5.5,-10.75],[-46,1.25],[-103.5,-9.75],[13.5,2.75],[14,-17.25],[-11.5,-19.25],[-37,-23.25],[-89.5,-19.25],[9.5,-16.75],[4,-41.75],[-17.5,-46.75],[-35,-36.75],[-83.5,-58.75]];
    const frameR3 = [[14.5,83.25],[-48,40.25],[-86.5,28.25],[-121,25.25],[-158.5,38.25],[15.5,33.75],[-23,3.75],[-57.5,-14.25],[-89,-6.25],[-140.5,13.75],[14.5,16.25],[-18,-18.75],[-52.5,-35.75],[-86,-28.75],[-137.5,-30.75],[13.5,2.75],[-21,-33.25],[-43.5,-54.25],[-72,-65.25],[-116.5,-33.25],[9.5,-16.75],[-17,-69.75],[-40.5,-83.75],[-64,-79.75],[-108.5,-60.75]];
    const frameR4 = [[14.5,83.25],[-87,40.25],[-129.5,20.25],[-164,18.25],[-208.5,41.25],[15.5,33.75],[-65,4.75],[-110.5,-20.25],[-154,-18.25],[-177.5,19.75],[14.5,16.25],[-57,-24.75],[-80.5,-47.75],[-127,-32.75],[-172.5,-37.75],[13.5,2.75],[-53,-45.25],[-74.5,-81.25],[-104,-78.25],[-157.5,-87.25],[9.5,-16.75],[-41,-90.75],[-76.5,-126.75],[-94,-120.75],[-152.5,-163.75]];
    const frameR5 = [[14.5,83.25],[-87,40.25],[-182.5,18.25],[-274,4.25],[-361.5,0],[15.5,33.75],[-65,4.75],[-151.5,-36.25],[-250,-50.25],[-335.5,-52.25],[14.5,16.25],[-57,-24.75],[-149.5,-72.75],[-219,-95.75],[-303.5,-122.75],[13.5,2.75],[-53,-45.25],[-137.5,-95.25],[-219,-119.25],[-303.5,-149.25],[9.5,-16.75],[-41,-90.75],[-124.5,-136.75],[-216,-169.75],[-314.5,-251.75]];
    const frameR6 = [[14.5,83.25],[-112,62.25],[-238.5,44.25],[-365,32.25],[-488.5,15.25],[15.5,33.75],[-115,5.75],[-251.5,-26.25],[-377,-47.25],[-502.5,-72.25],[14.5,16.25],[-117,-22.75],[-242.5,-56.75],[-377,-91.75],[-497.5,-119.75],[13.5,2.75],[-112,-33.25],[-246.5,-61.25],[-380,-97.25],[-515.5,-126.25],[9.5,-16.75],[-114,-46.75],[-245.5,-80.75],[-380,-115.75],[-511.5,-142.75]];
    
    const flipPageL = [frame1, frame2, frame3, frame4, frame5];
    const flipPageL2 = [frame5, frame4, frame3, frame2, frame1];

    const flipPageR = [frameR1, frameR2, frameR3, frameR4, frameR5, frameR6];
    const flipPageR2 = [frameR6, frameR5, frameR4, frameR3, frameR2, frameR1];

    // const imgW = Math.min(window.innerWidth - 10, 700);
    // img.width = imgW;
    // img.style.display = "none";
    // img.src = `assets/img/webp/ballad_seven.webp`;

    // imgR.style.display = "none";
    // imgR.src = `assets/img/webp/ballad_sftsk.webp`;

    let imgInit = false;
    let imgRInit = false;
    let imgPrevInit = false;

    img.onload = function()
    {
        img.width *= 0.59;
        img.height *= 0.59;
      if(!imgInit){
        w = canv.width = img.width;
        h = canv.height = img.height;

        updateUI(ctxL, img, cornersL, cornersLMod, 1);
        cornersLMod.forEach((x,idx) => {
            x[0] += frame1[idx][0];
            x[1] += frame1[idx][1];
        })
        updateUI(ctxL, img, cornersL, cornersLMod, 1);
        imgInit = true;
      }
    };

    
    imgPrev.onload = function()
    {
      if(!imgPrevInit){
        imgPrev.width *= 0.59;
        imgPrev.height *= 0.59;
        imgPrevInit = true;
      }
    }

    imgR.onload = function()
    {
        imgR.width *= 0.59;
        imgR.height *= 0.59;
      if(!imgRInit){
        w = canvR.width = imgR.width;
        h = canvR.height = imgR.height;

        updateUI(ctxR, imgR, cornersR, cornersRMod, 1);
        cornersRMod.forEach((x,idx) => {
            x[0] += frameR1[idx][0];
            x[1] += frameR1[idx][1];
        })
        updateUI(ctxR, imgR, cornersR, cornersRMod, 1);
        imgRInit = true;
      }
    };

      //animation
      let animating = false;
      let zero;
      let curFrame = 0;
      let duration = 250;

      function flipFrameL(timestamp, rev) {
        animating = true;
        curFrame = 0;
        zero = timestamp;
        animateL(timestamp, rev);
        canv.style.zIndex = 2;
        canvR.style.zIndex = 1;
      }
      function animateL(timestamp, rev) {
        // const cc = document.querySelector('#c');
        const img = document.querySelector('#i');
        
        const value = (timestamp - zero) / duration;
        const frames = rev===0 ? flipPageL : flipPageL2;
        if (value < 1) {
          //  cc.style.opacity = value;
            cornersLMod.forEach((x,idx) => {
                x[0] = cornersL[idx][0] + frame1[idx][0];
                x[1] = cornersL[idx][1] + frame1[idx][1];
            })
            updateUI(ctxL, img, cornersL, cornersLMod, 1);
            cornersLMod.forEach((x,idx) => {
                // x[0] -= frame1[idx][0];
                // x[1] -= frame1[idx][1];
                const dx = (frames[curFrame+1][idx][0] - frames[curFrame][idx][0]) * value;
                const dy = (frames[curFrame+1][idx][1] - frames[curFrame][idx][1]) * value;
                  x[0] = cornersL[idx][0] + frames[curFrame][idx][0] + dx;
                  x[1] = cornersL[idx][1] + frames[curFrame][idx][1] + dy;
            })
            updateUI(ctxL, imgPrev, cornersL, cornersLMod);
          requestAnimationFrame((t) => animateL(t, rev));
        } else if (curFrame < frames.length-2) {
          curFrame++
          zero = timestamp;
          requestAnimationFrame((t) => animateL(t, rev));
        } else if (curFrame < frames.length-1 && rev == 0) {
          cornersLMod.forEach((x,idx) => {
              x[0] = cornersL[idx][0] + frame1[idx][0];
              x[1] = cornersL[idx][1] + frame1[idx][1];
          })
          updateUI(ctxL, img, cornersL, cornersLMod, 1);
          imgPrev.src = `assets/img/webp/${ballads[(curBallad+1) % ballads.length]}.webp`;
          requestAnimationFrame((t) => flipFrameR(t, !rev));
        } else if (rev == 1) {
          animating = false;
          img.width *= 1.695;
          img.height *= 1.695;
          img.src = `assets/img/webp/${ballads[(curBallad)]}.webp`;
          
        }
      }
      
      function flipFrameR(timestamp, rev) {
        animating = true;
        curFrame = 0;
        zero = timestamp;
        animateR(timestamp, rev);
        canvR.style.zIndex = 2;
        canv.style.zIndex = 1;
      }
      function animateR(timestamp, rev) {
        // const cc = document.querySelector('#c');
        const img = document.querySelector('#i');
        
        const value = (timestamp - zero) / duration;
        const frames = rev===0 ? flipPageR : flipPageR2;
        if (value < 1) {
            cornersRMod.forEach((x,idx) => {
                x[0] = cornersR[idx][0] + frameR1[idx][0];
                x[1] = cornersR[idx][1] + frameR1[idx][1];
            });
            updateUI(ctxR, imgR, cornersR, cornersRMod, 1);
          //  cc.style.opacity = value;
          
          cornersRMod.forEach((x,idx) => {
              // x[0] -= frame1[idx][0];
              // x[1] -= frame1[idx][1];
              const dx = (frames[curFrame+1][idx][0] - frames[curFrame][idx][0]) * value;
              const dy = (frames[curFrame+1][idx][1] - frames[curFrame][idx][1]) * value;
                x[0] = cornersR[idx][0] + frames[curFrame][idx][0] + dx;
                x[1] = cornersR[idx][1] + frames[curFrame][idx][1] + dy;
          })
          updateUI(ctxR, imgPrev, cornersR, cornersRMod);
          requestAnimationFrame((t) => animateR(t, rev));
        } else if (curFrame < frames.length-2) {
          curFrame++
          zero = timestamp;
          requestAnimationFrame((t) => animateR(t, rev));
        } else if (curFrame < frames.length-1 && rev == 0) {
          cornersRMod.forEach((x,idx) => {
              x[0] = cornersR[idx][0] + frameR1[idx][0];
              x[1] = cornersR[idx][1] + frameR1[idx][1];
          });
          updateUI(ctxR, imgR, cornersR, cornersRMod, 1);
          imgPrev.src = `assets/img/webp/${ballads[(curBallad)]}.webp`;
          requestAnimationFrame((t) => flipFrameL(t, !rev));
        } else if (rev == 1) {
          animating = false;
          imgR.width *= 1.695;
          imgR.height *= 1.695;
          imgR.src = `assets/img/webp/${ballads[(curBallad+1) % ballads.length]}.webp`;
          
        }
      }

    // document.addEventListener('keydown', function(event) {
    //     if(event.key == '1') {
    //         requestAnimationFrame((t) => flipFrameL(t, 0));
    //     }
    //     if(event.key == '2') {
    //         requestAnimationFrame((t) => flipFrameL(t, 1));
    //     }
    //     if(event.key == '3') {
    //         requestAnimationFrame((t) => flipFrameR(t, 0));
    //     }
    //     if(event.key == '4') {
    //         requestAnimationFrame((t) => flipFrameR(t, 1));
    //     }
    // });

  }

const ballads = ["ballad_seven", "ballad_sftsk", "ballad_milady"];
const balladNames = ["Seven", "Seeking For the Sea King", "Milady"];
let curBallad = 0; //ballads id of left page 

  function renderBallad(song) {
    const scrn = Math.min(document.body.clientWidth, document.body.clientHeight) + "px";
    //if the song is a right-page ballad
    //we want to: put otherpage to -1 instead of +1
    //-> main page pos stays the same 
    //-> other page and book get shifted
    let isOdd = (ballads.indexOf(song)+1) % 2 == 0;
    let nextBallad;
    if(isOdd){
      nextBallad = ballads.indexOf(song)-1;
    } else {
      nextBallad = ballads.indexOf(song)+1 > ballads.length-1 ? 0 : ballads.indexOf(song)+1;
    }
    let bookLeft = isOdd ? `-88%` : `-12%`;
    let balladLeft = isOdd ? `-62.25%` : `89.5%`;
    let balladTilt = isOdd ? `-1` : `1`;
    document.body.innerHTML = `
      <div class="square-container">
        <div class="background"></div>
        <div class="crystalbackground">
        <div style="position:absolute; width: 100%; height: 100%;">
            <canvas id="canvas" width="1200px" height="800px" style="border:0px solid #d3d3d3; position: absolute; top: -5%; left: -10%; z-index: -2; opacity: 95%;">
            Your browser does not support the HTML5 canvas tag.</canvas>
        </div>
        <div style="overflow-x: hidden" class="inspectpage">
          <img src="assets/img/webp/${song}.webp" alt="seven"  style="position: absolute; top: 16%; left:14%; width: 73%; transform: rotateZ(${0.5 * balladTilt}deg); padding-bottom: 50%; z-index: 1"/>
          
          <img src="assets/img/webp/${ballads[nextBallad]}.webp" alt="seven"  style="position: absolute; top: 16%; left: ${balladLeft}; width: 73%; transform: rotateZ(${-0.5 * balladTilt}deg); padding-bottom: 50%; z-index: 1"/>
          <img src="assets/img/webp/songbook_detail.webp" alt="songbook"  style="position: absolute; top: -22%; left: ${bookLeft}; width: 200%; pointer-events: none;"/>
        
        </div>
        <div>
          <img src="assets/img/webp/purchase_textmouse.webp" style="position: absolute; top: 0%; left:0px; max-height: 100%; max-width: 100%; height: 100%; width: 100%; z-index: 1; pointer-events: none; "/>
            <div style="position: absolute; left: 28%; top: 81%; z-index: 3; width: 59%;" class="text-container">
            <p style="font-size: 0.85rem;">I much like "${balladNames[ballads.indexOf(song)]}" myself! Would you like to <span id="purchase" style="color: blue; text-decoration: underline; cursor: pointer;">purchase</span> a copy?</p>
            </div>
        </div>
        <img src="assets/img/webp/button_back.webp" alt="back" id="buttonBack"  class="buttonBack"  style="cursor: pointer; position: absolute; top: 2%; left: 2%; max-width: 100%; width: 7%; z-index: 3"/>
        </div>
        </div>
      </div>
    `
    const size = Math.min(document.body.clientWidth, document.body.clientHeight) * 1.2;
    startOrbCanvas(size, size);
      const backBtn = document.getElementById(`buttonBack`);
      backBtn.onclick = () => {
        renderSong();
      };
      
      const purchase = document.getElementById(`purchase`);
      purchase.onclick = () => {
        renderPurchaseBallad(song);
      };
      //renderOrb(document.body.clientWidth * 2,document.body.clientHeight * 2);
  }


  function renderMail() {
    const scrn = Math.min(document.body.clientWidth, document.body.clientHeight) + "px";
    document.body.innerHTML = `
      <div class="square-container">
        <div class="background"></div>
        <div class="crystalbackground">
        <div style="position:absolute; width: 100%; height: 100%;">
            <canvas id="canvas" width="1200px" height="800px" style="border:0px solid #d3d3d3; position: absolute; top: -5%; left: -10%; z-index: -2; opacity: 95%;">
            Your browser does not support the HTML5 canvas tag.</canvas>
        </div>
        <img src="assets/img/webp/mail_form.webp" alt="form" style="max-width: 100%; height: 100%; width: 100%; "/>
        <span style="font-weight: bold; font-size: 2.4rem; color: #2E2B1D; position: absolute; top: 11%; left:10%; max-height: 100%; z-index: 2">We are most delighted</span>
        <span style="font-weight: bold; font-size: 1.4rem; color: #2E2B1D; position: absolute; top: 21%; left:10%; max-height: 100%; z-index: 2">that you wish to be notified when the</span>
        <span style="font-weight: bold; font-size: 2.1rem; color: #2E2B1D; position: absolute; top: 29%; left:10%; max-height: 100%; z-index: 2">Secret Wizard Scrolls <span style="font-size: 1.5rem">shall</span></span>
        <span style="font-weight: bold; font-size: 1.4rem; color: #2E2B1D; position: absolute; top: 38%; left:11%; max-height: 100%; z-index: 2">be ready for public perusal! Please</span>
        <span style="font-weight: bold; font-size: 1.4rem; color: #2E2B1D; position: absolute; top: 44%; left:31%; max-height: 100%; z-index: 2">provide us with your:</span>
        
        <img src="assets/img/webp/mail_name.webp" alt="name" style="position: absolute; top: 0; left: 0; max-width: 100%; height: 100%; width: 100%; "/> 
        <img src="assets/img/webp/mail_email.webp" alt="email" style="position: absolute; top: 0; left: 0; max-width: 100%; height: 100%; width: 100%; "/> 
        <img src="assets/img/webp/mail_mouse.webp" id="mouse" alt="mouse" style="transform-origin: 50% 50%; position: absolute; top: 0; left: 0; max-width: 100%; height: 100%; width: 100%; "/> 
        <img src="assets/img/webp/mail_hands.webp" id="hands" alt="point" style="position: absolute; top: 0; left: 0; max-width: 100%; height: 100%; width: 100%; "/> 
        <img src="assets/img/webp/mail_submit.webp" id="submit" alt="submit" style="position: absolute; top: 0; left: 0; max-width: 100%; height: 100%; width: 100%; "/> 
        
        <img src="assets/img/webp/button_back.webp" alt="back" id="buttonBack"  class="buttonBack"  style="cursor: pointer; position: absolute; top: 2%; left: 2%; max-width: 100%; width: 7%; z-index: 3"/>
        
        <form action="" method="POST">
          <input type="text" placeholder="Name" class="signup" style="text-align: center; outline: none; font-family: Courier New; font-size: 1.4rem; color: #000000ff; background: none; position: absolute; border: none; width: 45%; top: 54.5%; left:37%; transform: rotateZ(3deg); max-height: 100%; max-width: 100%; z-index: 2" name="name"/>
          <input type="text" placeholder="Email" id="email" class="signup" style="text-align: center; outline: none; font-family: Courier New; font-size: 1.4rem; color: #000000ff; background: none; position: absolute; border: none; width: 60%; top: 66%; left:30%; transform: rotateZ(0.5deg); max-height: 100%; max-width: 100%; z-index: 2" name="email" required/>
          <input type="submit" id="submitBtn" value="" style="cursor: pointer; background: none; border: none; position: absolute; top: 77.5%; left: 36%; height: 12%; width: 29%;"/>
        </form>
        </div>
        </div>
      </div>
    `

    
      const backBtn = document.getElementById(`buttonBack`);
      backBtn.onclick = () => {
        renderMainUI();
      };
    const size = Math.min(document.body.clientWidth, document.body.clientHeight) * 1.2;
    startOrbCanvas(size, size);
    //renderOrb(document.body.clientWidth * 2,document.body.clientHeight * 2);
    let jump = false;
      const email = document.getElementById(`email`);
      const mouse = document.getElementById(`mouse`);
      const hands = document.getElementById(`hands`);
      mouse.style.transform = `rotateZ(7deg)`;
      function anim(){
          setTimeout(function() {
          const rot = jump ? 7 : 0;
          const img = jump ? "mail_hands_twist.webp" : "mail_hands.webp";
          if(email.value.match(/^\S+@\S+\.\S+$/))hands.src = `assets/img/webp/${img}`;
          mouse.style.transform = `rotateZ(${rot}deg)`;
          jump = !jump;
          anim();
          }, 666);
      }

      anim();

      const submit = document.getElementById(`submit`);
      const submitBtn = document.getElementById(`submitBtn`);
      // if(scroll) search.value = scroll;
      // const submit = document.getElementById(`submit`);
      submitBtn.onclick = () => {
        submit.src = "assets/img/webp/mail_submit_down.webp";
        setTimeout(function() {
        submit.src = "assets/img/webp/mail_submit.webp";
        }, 200);
      };
      // submit.addEventListener('mouseenter', () => {
      //   submit.style.color = "#ffffff";
      // });
      // submit.addEventListener('mouseleave', () => {
      //   submit.style.color = "#454D66";
      // });
      
      // const backBtn = document.getElementById(`buttonBack`);
      // backBtn.onclick = () => {
      //   renderMainUI();
      // };
  }


  function renderCommissions(scroll) {
    const scrn = Math.min(document.body.clientWidth, document.body.clientHeight) + "px";
    document.body.innerHTML = `
      <div class="square-container">
        <div class="background"></div>
        <div class="crystalbackground">
        <div style="position:absolute; width: 100%; height: 100%;">
            <canvas id="canvas" width="1200px" height="800px" style="border:0px solid #d3d3d3; position: absolute; top: -5%; left: -10%; z-index: -2; opacity: 95%;">
            Your browser does not support the HTML5 canvas tag.</canvas>
        </div>
        <img src="assets/img/webp/purchase_book.webp" alt="scroll" style="max-width: 100%; height: 100%; width: 100%; "/>
        <img src="assets/img/webp/purchase_1.webp" alt="continue" style=" position: absolute; top: 0%; left: 0%; max-width: 100%; width: 100%; z-index: 3"/>
        <img src="assets/img/webp/purchase_2.webp" alt="change"  style=" position: absolute; top: 0%; left: 0%; max-width: 100%; width: 100%; z-index: 3"/>
        <p id="textp1" style="padding: none; margin: none; text-align: justify; overflow-wrap: break-word; overflow: hidden; color: #795841; font-size: 0.75em; line-height: 1em; font-weight: bold; opacity: 90%; position: absolute; top: 33%; left: 30%; transform: rotateX(10deg) skewX(5deg); z-index: 0; width: 47%; height: 40%; border:;"></p>
        <p id="textp2" style="padding: none; margin: none; text-align: justify; overflow-wrap: break-word; overflow: hidden; color: #795841; font-size: 0.75em; line-height: 1em; font-weight: bold; opacity: 90%; position: absolute; top: 17%; left: 81%; transform: rotateX(20deg) skewX(10deg); z-index: 0; width: 47%; height: 58%; border:;"></p>
        <p id="sizer" style='padding: none; margin: none; text-align: justify; overflow-wrap: break-word; font-size: 0.75em; line-height: 1em; font-weight: bold; position: absolute; top: 33%; left: 30%; transform: rotateX(-10deg) skewX(2deg); z-index: -1; width: 47%; visibility: hidden; white-space: normal;'><p/>
        <p id="btn_com1" style="cursor: pointer; position: absolute; top: 77%; left: 12%; z-index: 6; width: 300px; height: 125px; border:"></p>
        <p id="btn_com2" style="cursor: pointer; position: absolute; top: 77%; left: 57%; z-index: 6; width: 300px; height: 125px; border:"></p>
          <img src="assets/img/webp/purchase_quill.webp" id="comQuill" alt="commission"  style="position: absolute; top: 0%; left: 0%; max-width: 100%; width: 100%; z-index: 1"/>
        <img src="assets/img/webp/button_back.webp" alt="back" id="buttonBack"  class="buttonBack"  style="cursor: pointer; position: absolute; top: 2%; left: 2%; max-width: 100%; width: 7%; z-index: 4"/>
        </div>
        </div>
      </div>
    `

    // console.log(tales[curTale])

    const size = Math.min(document.body.clientWidth, document.body.clientHeight) * 1.2;
    startOrbCanvas(size, size);
      //const canvas = document.getElementById('canvas');
      //renderOrb(document.body.clientWidth * 0.5,document.body.clientHeight * 0.5);

      const contText1 = document.getElementById(`textp1`);
      const contText2 = document.getElementById(`textp2`);
      const sizer = document.getElementById("sizer");

      // Call the function and update the text
      continueText = tales[curTale];
      findCutIndex(contText1, sizer, tales[curTale]);
      // console.log(continueText)
      
      contText2.innerHTML = continueText;

      const buttonCom1 = document.getElementById(`btn_com1`);
      buttonCom1.onclick = () => {
        // renderMainUI(1); // under construction mode
        renderPurchase(0);
      };
      const buttonCom2 = document.getElementById(`btn_com2`);
      buttonCom2.onclick = () => {
        // renderMainUI(1);
        renderPurchase(1);
      };

      const comQuill = document.getElementById(`comQuill`);
      
      buttonCom1.addEventListener('mouseenter', () => {
        comQuill.src="assets/img/webp/purchase_quill1.webp";
      });
      buttonCom1.addEventListener('mouseleave', () => {
        comQuill.src="assets/img/webp/purchase_quill.webp";
        //flipL.style.display = "none";
      });
      buttonCom2.addEventListener('mouseenter', () => {
        comQuill.src="assets/img/webp/purchase_quill2.webp";
      });
      buttonCom2.addEventListener('mouseleave', () => {
        comQuill.src="assets/img/webp/purchase_quill.webp";
        //flipL.style.display = "none";
      });

      const backBtn = document.getElementById(`buttonBack`);
      backBtn.onclick = () => {
        if(scroll) {
          continueText = tales[curTale];
          renderScrolls();
        } else {
          renderMainUI();
        }
      };
      
    
  }

  
  function renderPurchase(two_chapters) {
    const scrn = Math.min(document.body.clientWidth, document.body.clientHeight) + "px";

    const price = two_chapters? '40' : '25';
    const amount = two_chapters? 'TWO CHAPTERS' : 'CHAPTER';
    document.body.innerHTML = `
      <div class="square-container">
        <div class="background"></div>
        <div class="crystalbackground">
        <div style="position:absolute; width: 100%; height: 100%;">
            <canvas id="canvas" width="1200px" height="800px" style="border:0px solid #d3d3d3; position: absolute; top: -5%; left: -10%; z-index: -2; opacity: 95%;">
            Your browser does not support the HTML5 canvas tag.</canvas>
        </div>
        <img src="assets/img/webp/mail_form.webp" alt="form" style="max-width: 100%; height: 100%; width: 100%; "/>
        <span style="font-weight: bold; font-size: 2.3rem; color: #2E2B1D; position: absolute; top: 11%; left:10%; max-height: 100%; max-width: 100%; z-index: 2">Within a week shall ye</span>
        <span style="font-weight: bold; font-size: 1.2rem; color: #2E2B1D; position: absolute; top: 21%; left:11%; max-height: 100%; max-width: 100%; z-index: 2">receive the next <span style="font-size: 1.4rem; font-style: italic;">${amount} of</span></span>
        <span style="font-weight: bold; font-size: 1.2rem; color: #2E2B1D; position: absolute; top: 27%; left:11%; max-height: 100%; max-width: 100%; z-index: 2">this <span style="font-size: 1.8rem">fine scroll</span>... for a mere <span style="font-size: 2.5rem;">$<span style="color: #5A599B;">${price}</span>!</span></span>
        <span style="font-weight: bold; font-size: 1.2rem; color: #2E2B1D; position: absolute; top: 38%; left:11%; max-height: 100%; max-width: 100%; z-index: 2">You have only to provide me with your:</span>
        <span style="font-weight: 0; font-size: 0.7rem; color: #ffffff; position: absolute; top: 94%; left:20%; max-height: 100%; max-width: 100%; z-index: 2">*Secure payments processed by the foreign magic of Stripe.</span>
        
        <img src="assets/img/webp/mail_name.webp" alt="name" style="position: absolute; top: -8%; left: 0; max-width: 100% height: 100%; width: 100%; "/> 
        <img src="assets/img/webp/mail_email.webp" alt="email" style="position: absolute; top: -10%; left: 0; transform: rotateZ(3deg); max-width: 100% height: 100%; width: 100%; "/> 
        <img src="assets/img/webp/mail_email.webp" alt="card" style="position: absolute; top: 0%; left: 0; max-width: 100% height: 100%; width: 100%; "/> 
        <img src="assets/img/webp/mail_mouse.webp" id="mouse" alt="mouse" style="transform-origin: 50% 50%; position: absolute; top: 0; left: 0; max-width: 100% height: 100%; width: 100%; "/> 
        <img src="assets/img/webp/mail_hands.webp" id="hands" alt="point" style="position: absolute; top: 0; left: 0; max-width: 100% height: 100%; width: 100%; "/> 
        <img src="assets/img/webp/purchase_btn_pay.webp" id="submit" alt="submit" style="position: absolute; top: 0; left: 0; max-width: 100%; height: 100%; width: 100%; "/>
       
        <img src="assets/img/webp/button_back.webp" alt="back" id="buttonBack"  class="buttonBack"  style="cursor: pointer; position: absolute; top: 2%; left: 2%; max-width: 100%; width: 7%; z-index: 4"/>
       
        <form id="payment-form">
          <textarea id="message" placeholder="Name"style="text-align: center; outline: none; font-family: Courier New; font-size: 1.0rem; color: #000000ff; background: none; position: absolute; border: none; width: 60%; top: 48%; left:30%; transform: rotateZ(0.5deg); max-height: 100%; max-width: 100%; z-index: 2" name="message"></textarea>
          <input type="email" id="email" placeholder="Email" required style="text-align: center; outline: none; font-family: Courier New; font-size: 1.0rem; color: #000000ff; background: none; position: absolute; border: none; width: 45%; top: 56.5%; left:37%; transform: rotateZ(3deg); max-height: 100%; max-width: 100%; z-index: 2" name="email"/>
          
          <div id="card-element" style="text-align: center; outline: none; font-family: Courier New; font-size: 1.2rem; color: #000000ff; background: none; position: absolute; width: 50%; height:5%; top: 68%; left:33%; transform: rotateZ(0.5deg); max-height: 100%; max-width: 100%; z-index: 2"></div>

          <button id="submitBtn" style="background: none; border: none; position: absolute; top: 77.5%; left: 36%; height: 12%; width: 29%;">
          </button>
          <div id="error-message"></div>
        </form>
        </div>
        </div>
      </div>
    `
    const size = Math.min(document.body.clientWidth, document.body.clientHeight) * 1.2;
    startOrbCanvas(size, size);
    //renderOrb(document.body.clientWidth * 2,document.body.clientHeight * 2);
    let jump = false;
      const email = document.getElementById(`email`);
      const mouse = document.getElementById(`mouse`);
      const hands = document.getElementById(`hands`);
      mouse.style.transform = `rotateZ(7deg)`;
      function anim(){
          setTimeout(function() {
          const rot = jump ? 7 : 0;
          const img = jump ? "mail_hands_twist.webp" : "mail_hands.webp";
          if(email.value.match(/^\S+@\S+\.\S+$/))hands.src = `assets/img/webp/${img}`;
          mouse.style.transform = `rotateZ(${rot}deg)`;
          jump = !jump;
          anim();
          }, 666);
      }

      anim();


      const submit = document.getElementById(`submit`);
      // const submitBtn = document.getElementById(`submitBtn`);
      // // if(scroll) search.value = scroll;
      // // const submit = document.getElementById(`submit`);
      // submitBtn.onclick = () => {
      // };

      
      const stripe = Stripe('pk_live_');
      const elements = stripe.elements();

      const card = elements.create('card', {
        style: {
          base: {
            fontFamily: 'system-ui, sans-serif',
            fontSize: '16px',
          }
        }
      });

      card.mount('#card-element');

      const form = document.getElementById('payment-form');

      form.addEventListener('submit', async (e) => {
        e.preventDefault();

        submit.src = "assets/img/webp/purchase_btn_pay_down.webp";
        setTimeout(function() {
        submit.src = "assets/img/webp/purchase_btn_pay.webp";
        }, 200);
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;
        const option = two_chapters? 'two_chapters' : 'one_chapter';
        const tale = `${curTale}`;

        const res = await fetch('/create-payment-intent.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email, message, option, tale })
        });

        const { clientSecret, error } = await res.json();
        if (error) {
          document.getElementById('error-message').textContent = error;
          return;
        }

        const result = await stripe.confirmCardPayment(clientSecret, {
          payment_method: {
            card,
            billing_details: { email }
          }
        });

        if (result.error) {
          document.getElementById('error-message').textContent = result.error.message;
        } else {
          window.location.href = '/';
        }
      });

      // submit.addEventListener('mouseenter', () => {
      //   submit.style.color = "#ffffff";
      // });
      // submit.addEventListener('mouseleave', () => {
      //   submit.style.color = "#454D66";
      // });
      
      const backBtn = document.getElementById(`buttonBack`);
      backBtn.onclick = () => {
        renderCommissions();
      };
  }


  
  function renderPurchaseBallad(ballad) {
    const scrn = Math.min(document.body.clientWidth, document.body.clientHeight) + "px";

    // const price = two_chapters? '40' : '25';
    // const amount = two_chapters? 'TWO CHAPTERS' : 'CHAPTER';
    const price = '40';
    const amount = '1';
    document.body.innerHTML = `
      <div class="square-container">
        <div class="background"></div>
        <div class="crystalbackground">
        <div style="position:absolute; width: 100%; height: 100%;">
            <canvas id="canvas" width="1200px" height="800px" style="border:0px solid #d3d3d3; position: absolute; top: -5%; left: -10%; z-index: -2; opacity: 95%;">
            Your browser does not support the HTML5 canvas tag.</canvas>
        </div>
        <img src="assets/img/webp/mail_form.webp" alt="form" style="max-width: 100%; height: 100%; width: 100%;"/>
        <span style="font-weight: bold; font-size: 2.3rem; color: #2E2B1D; position: absolute; top: 11%; left:10%; max-height: 100%; max-width: 100%; height: 100%; width: 100%;  z-index: 2">By courier shall ye soon</span>
        <span style="font-weight: bold; font-size: 1.2rem; color: #2E2B1D; position: absolute; top: 21%; left:11%; max-height: 100%; max-width: 100%; height: 100%; width: 100%;  z-index: 2">obtain a poster, <span style="font-size: 1.2rem;">dimensions 24" by 36",</span></span>
        <span style="font-weight: bold; font-size: 1.2rem; color: #2E2B1D; position: absolute; top: 27%; left:11%; max-height: 100%; max-width: 100%; height: 100%; width: 100%;  z-index: 2">of this exquisite <span style="font-size: 1.8rem">song</span> for a mere <span style="font-size: 2.5rem;">$<span style="color: #5A599B;">40</span></span></span>
        <span style="font-weight: bold; font-size: 1.2rem; color: #2E2B1D; position: absolute; top: 38%; left:11%; max-height: 100%; max-width: 100%; height: 100%; width: 100%;  z-index: 2"><span style="font-size: 0.9rem;">(plus shipping fees, of course).</span> I need only your:</span>
        <span style="font-weight: bold; font-size: 0.7rem; color: #ffffff; position: absolute; top: 94%; left:20%; max-height: 100%; max-width: 100%; height: 100%; width: 100%;  z-index: 2">*Secure payments processed by the foreign magic of Stripe</span>
        
        <div id="pageOne">
          <img src="assets/img/webp/mail_email.webp" style="position: absolute; top: -21%; left: 21%; max-width: 100%; height: 100%; width: 72%;"/> 
          <img src="assets/img/webp/mail_email.webp" style="position: absolute; top: 1%; left: 7%; transform: rotateZ(1deg); max-width: 100%; width: 95%; height: 80%;"/> 
          <img src="assets/img/webp/mail_email.webp" style="position: absolute; top: 9%; left: 6%; transform: rotateZ(1deg); max-width: 100%; width: 95%; height: 78%;"/> 
          <img src="assets/img/webp/mail_email.webp" style="position: absolute; top: 25%; left: 6%; transform: rotateZ(1deg); max-width: 100%; width: 94%; height: 74%;"/> 
          <img src="assets/img/webp/mail_email.webp" style="position: absolute; top: 15%; left: 7%; transform: rotateZ(1deg); max-width: 100%; width: 93%; height: 80%;"/> 
          <img src="assets/img/webp/purchase_btn_next.webp" style="position: absolute; top: 0; left: 0; max-width: 100%; height: 100%; width: 100%;"/>
          <div id="next" style="position: absolute; top: 80%; left: 37%; height: 11%; width: 27%; z-index: 5;"></div>
        </div>
      
        <div id="pageTwo" style="visibility: hidden; ">
          <img src="assets/img/webp/mail_email.webp" alt="email" style="position: absolute; top: -19%; left: 0; max-width: 100%; height: 100%; width: 100%;  transform: rotateZ(2deg);"/> 
          <img src="assets/img/webp/mail_email.webp" alt="astrological" style="position: absolute; top: 1%; left: 0; transform: rotateZ(1deg); max-width: 100%; width: 100%; height: 85%;"/> 
          <img src="assets/img/webp/mail_email.webp" alt="card" style="position: absolute; top: 0%; left: 0; max-width: 100%; width: 100%; height: 100%;"/> 
          <img src="assets/img/webp/purchase_btn_pay.webp" style="position: absolute; top: 0; left: 0; max-width: 100%; height: 100%; width: 100%; "/>
        </div>

        <form id="payment-form">
          <div id="pageOneForm" >
            <input type="text" id="name" placeholder="Name" style="text-align: center;  font-family: Courier New; font-size: 1.4rem; color: #000000ff; background: none; outline: none; position: absolute; border: none; width: 40%; top: 45%; left:45%; transform: rotateZ(1deg); max-height: 100%; max-width: 100%; z-index: 2" name="message"></input>
            <input type="text" id="address" placeholder="Civic address" style="text-align: center;  font-family: Courier New; font-size: 1.1rem; color: #000000ff; background: none; outline: none; position: absolute; border: none; width: 50%; top: 54%; left:40%; transform: rotateZ(2deg); max-height: 100%; max-width: 100%; z-index: 2" name="message"></input>
            <input type="text" id="city" placeholder="Municipality" style="text-align: center;  font-family: Courier New; font-size: 1.1rem; color: #000000ff; background: none; outline: none; position: absolute; border: none; width: 50%; top: 60.5%; left:39%; transform: rotateZ(2deg); max-height: 100%; max-width: 100%; z-index: 2" name="message"></input>
            <input type="text" id="prov" placeholder="Province" style="text-align: center;  font-family: Courier New; font-size: 1.1rem; color: #000000ff; background: none; outline: none; position: absolute; border: none; width: 50%; top: 67.75%; left:39%; transform: rotateZ(2deg); max-height: 100%; max-width: 100%; z-index: 2" name="message"></input>
            <input type="text" id="postal" placeholder="Postal code" style="text-align: center;  font-family: Courier New; font-size: 1.1rem; color: #000000ff; background: none; outline: none; position: absolute; border: none; width: 50%; top: 74%; left:38%; transform: rotateZ(2deg); max-height: 100%; max-width: 100%; z-index: 2" name="message"></input>
          </div>
          <div id="pageTwoForm" style="visibility: hidden;">
            <input type="email" id="email" placeholder="Email" required style="text-align: center;  font-family: Courier New; font-size: 1.0rem; color: #000000ff; background: none; position: absolute; border: none; width: 60%; top: 48%; left:30%; transform: rotateZ(2deg); max-height: 100%; max-width: 100%; z-index: 2" name="message"></input>
            <input id="dob" placeholder="Astrological sign" style="text-align: center;  font-family: Courier New; font-size: 1.0rem; color: #000000ff; background: none; position: absolute; border: none; width: 45%; top: 57.5%; left:37%; transform: rotateZ(1.25deg); max-height: 100%; max-width: 100%; z-index: 2" name="email"></input>
            
            <div id="card-element" style="text-align: center; outline: none; font-family: Courier New; font-size: 1.5rem; color: #000000ff; background: none; position: absolute; width: 50%; height: 100%; height:4.5%; top: 68%; left:33%; transform: rotateZ(0.5deg); max-height: 100%; max-width: 100%; z-index: 2"></div>

            <button id="submitBtn" style="background: none; border: none; position: absolute; top: 77.5%; left: 36%; height: 12%; width: 29%; z-index: 5;">
            </button>
          </div>
          <div id="error-message"></div>
        </form>
      
        <img src="assets/img/webp/mail_mouse.webp" id="mouse" alt="mouse" style="transform-origin: 50% 50%; position: absolute; top: -1%; left: 1%; max-width: 120%; width: 120%; height: 120%; transform: rotateZ(15deg);"/> 
        <img src="assets/img/webp/mail_hands.webp" id="hands" alt="point" style="position: absolute; top: 3%; left: 0; max-width: 100%; width: 100%; height: 100%;"/> 
        <img src="assets/img/webp/button_back.webp" alt="back" id="buttonBack"  class="buttonBack"  style="cursor: pointer; position: absolute; top: 2%; left: 2%; max-width: 100%; width: 7%; z-index: 4"/>
        </div>
        </div>
      </div>
    `
    const size = Math.min(document.body.clientWidth, document.body.clientHeight) * 1.2;
    startOrbCanvas(size, size);
    //renderOrb(document.body.clientWidth * 2,document.body.clientHeight * 2);
    let jump = false;
      const email = document.getElementById(`email`);
      const mouse = document.getElementById(`mouse`);
      const hands = document.getElementById(`hands`);
      mouse.style.transform = `rotateZ(15deg)`;
      function anim(){
          setTimeout(function() {
          const rot = jump ? 15 : 10;
          const img = jump ? "mail_hands_twist.webp" : "mail_hands.webp";
          if(email.value.match(/^\S+@\S+\.\S+$/))hands.src = `assets/img/webp/${img}`;
          mouse.style.transform = `rotateZ(${rot}deg)`;
          jump = !jump;
          anim();
          }, 666);
      }

      anim();


      const next = document.getElementById(`next`);
      const pg1 = document.getElementById(`pageOne`);
      const pg1f = document.getElementById(`pageOneForm`);
      const pg2 = document.getElementById(`pageTwo`);
      const pg2f = document.getElementById(`pageTwoForm`);
      next.onclick = () => {
        pg1.style.visibility = "hidden";
        pg1f.style.visibility = "hidden";
        pg2.style.visibility = "visible";
        pg2f.style.visibility = "visible";
      }
      

      const submit = document.getElementById(`submit`);
      // const submitBtn = document.getElementById(`submitBtn`);
      // // if(scroll) search.value = scroll;
      // // const submit = document.getElementById(`submit`);
      // submitBtn.onclick = () => {
      // };

      
      const stripe = Stripe('pk_live_');
      const elements = stripe.elements();

      const card = elements.create('card', {
        style: {
          base: {
            fontFamily: 'system-ui, sans-serif',
            fontSize: '16px',
          }
        }
      });

      card.mount('#card-element');

      const form = document.getElementById('payment-form');

      form.addEventListener('submit', async (e) => {
        e.preventDefault();

        submit.src = "assets/img/webp/purchase_btn_pay_down.webp";
        setTimeout(function() {
        submit.src = "assets/img/webp/purchase_btn_pay.webp";
        }, 200);
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;
        const option = 'two_chapters';
        const tale = `${ballad}`;

        const res = await fetch('/create-payment-intent.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email, message, option, tale })
        });

        const { clientSecret, error } = await res.json();
        if (error) {
          document.getElementById('error-message').textContent = error;
          return;
        }

        const result = await stripe.confirmCardPayment(clientSecret, {
          payment_method: {
            card,
            billing_details: { email }
          }
        });

        if (result.error) {
          document.getElementById('error-message').textContent = result.error.message;
        } else {
          window.location.href = '/';
        }
      });

      // submit.addEventListener('mouseenter', () => {
      //   submit.style.color = "#ffffff";
      // });
      // submit.addEventListener('mouseleave', () => {
      //   submit.style.color = "#454D66";
      // });
      
      const backBtn = document.getElementById(`buttonBack`);
      backBtn.onclick = () => {
        renderBallad(ballad);
      };
  }

  function renderSheherezade() {
    
    document.body.innerHTML = `
      <div class="square-container">
        <div class="background"></div>
        <div class="crystalbackground">
        <div style="position:absolute; width: 100%; height: 100%;">
            <canvas id="canvas" width="1200px" height="800px" style="border:0px solid #d3d3d3; position: absolute; top: -5%; left: -10%; z-index: -2; opacity: 95%;">
            Your browser does not support the HTML5 canvas tag.</canvas>
        </div>
      
        <img src="assets/img/webp/she_tablecloth.webp" style="position: absolute; top: 0%; left: 0%; width: 100%;" />
        <img src="assets/img/webp/she_vertical_books.webp" style="position: absolute; top: 0%; left: 0%; width: 100%;" />
        <img src="assets/img/webp/she_wooden_box.webp" style="position: absolute; top: 0%; left: 0%; width: 100%;" />
        <img src="assets/img/webp/she_two_books.webp" style="position: absolute; top: 0%; left: 0%; width: 100%;" />
        <img src="assets/img/webp/she_open_book.webp" style="position: absolute; top: 0%; left: 0%; width: 100%; z-index: 1;" />
        <img src="assets/img/webp/she_shell_right.webp" style="position: absolute; top: 0%; left: 0%; width: 100%; z-index: 1;" />
        <img id="shrightHL" src='assets/img/webp/highlight.webp' style="position:absolute; width:14%; height:14%; bottom:37%; left:59%; z-index: 0; visibility: hidden;"/>
        <img src="assets/img/webp/she_shell_left.webp" style="position: absolute; top: 0%; left: 0%; width: 100%; z-index: 1;" />
        <img id="shleftHL" src='assets/img/webp/highlight.webp' style="position:absolute; width:14%; height:14%; bottom:37%; left:32%; z-index: 0; visibility: hidden;"/>
        <img src="assets/img/webp/she_shell_big.webp" style="position: absolute; top: 0%; left: 0%; width: 100%; z-index: 1;" />
        <img id="shbigHL" src='assets/img/webp/highlight.webp' style="position:absolute; width:42%; height:25%; bottom:21%; left:8%; z-index: 0; visibility: hidden;"/>
        <img src="assets/img/webp/she_glass_empty.webp" style="position: absolute; top: 0%; left: 0%; width: 100%; z-index: 1;" />
        <img id="glassHL" src='assets/img/webp/highlight.webp' style="position:absolute; width:24%; height:36%; bottom:39%; left:20%; z-index: 0; visibility: hidden;"/>
        <img src="assets/img/webp/she_glass_swan.webp" style="position: absolute; top: 0%; left: 0%; width: 100%; z-index: 1;" />
        <img id="swanHL" src='assets/img/webp/highlight.webp' style="position:absolute; width:22%; height:75%; bottom:18%; left:-1%; z-index: 0; visibility: hidden;"/>
        <img src="assets/img/webp/she_statue.webp" id="sch_statue" style="position: absolute; top: 0%; left: 0%; width: 100%; z-index: 2;" />
        <img id="statueHL" src='assets/img/webp/highlight.webp' style="width:33%; height:60%; position: absolute; left: 35%; bottom: 42%; z-index: 0; visibility: hidden;"/>
        
        
        <img src="assets/img/webp/she_letter.webp" style="position: absolute; top: 0%; left: 0%; width: 100%; z-index: 1;" />
        <img id="letterHL" src='assets/img/webp/highlight.webp' style="width:27%; position: absolute; left: 44%; bottom: 20%; z-index: 0; visibility: hidden;"/>
        
        <div id="letter" style="cursor: pointer; position:absolute; width:20%;height:20%; bottom:20%; left:47%; z-index:2;"></div>
        <div id="shright" style="border: none; cursor: pointer; position:absolute; width:7%; height:7%; bottom:41%; left:63%; z-index:2;"></div>
        <div id="shleft" style="border: none; cursor: pointer; position:absolute; width:7%; height:7%; bottom:40%; left:35%; z-index:2;"></div>
        <div id="shbig" style="border: none; cursor: pointer; position:absolute; width:26%; height:16%; bottom:24%; left:17%; z-index:2;"></div>
        <div id="glass" style="border: none; cursor: pointer; position:absolute; width:12%; height:18%; bottom:47%; left:25%; z-index:2;"></div>
        <div id="swan" style="border: none; cursor: pointer; position:absolute; width:14%; height:50%; bottom:27%; left:3%; z-index:2;"></div>
        <div id="statue" style="border: none; cursor: pointer; position:absolute; width:15%; height:40%; bottom:46%; left:42%; z-index:2;"></div>
        
        <div id="textmouse">
          <img src="assets/img/webp/text_mouse.webp" style="position: absolute; top: 73%; left:3%; width: 95%; max-height: 100%; max-width: 100%; z-index: 1; pointer-events: none; "/>
            <div style="position: absolute; left: 22%; top: 77%; z-index: 3; width: 70%;" class="text-container">
            <p id="mouseSays" style="font-size: 0.95rem;">On the far side of the Wizard's writing—desk stands a yellow statuette you have no choice but to reach out and touch...</p>
            </div>
        </div>
        
        <img src="assets/img/webp/button_back.webp" alt="back" id="buttonBack"  class="buttonBack"  style="cursor: pointer; position: absolute; top: 2%; left: 2%; max-width: 100%; width: 7%; z-index: 4"/>
       
        <img src="assets/img/webp/good_bubble.webp" id="bubble" style="position: absolute; top: 0%; left: 0%; width: 100%; visibility: hidden; z-index:2;" />
        <img src="assets/img/webp/good_text.webp" id="text" style="position: absolute; top: 0%; left: 0%; width: 100%; visibility: hidden; z-index:2;" />
        <img src="assets/img/webp/good_yes.webp" id="yes" style="position: absolute; top: 0%; left: 0%; width: 100%; visibility: hidden; z-index:2;" />
        <img src="assets/img/webp/good_no.webp" id="no" style="position: absolute; top: 0%; left: 0%; width: 100%; visibility: hidden; z-index:2;" />
        
        <div id="yesBtn" style="cursor: pointer; position:absolute; width:30%;height:17%; bottom:5%; left:22%; z-index:2;"></div>
        <div id="noBtn" style="cursor: pointer; position:absolute; width:30%;height:17%; bottom:5%; left:62%; z-index:2;"></div>
        
        <img src="assets/img/webp/good_banners.webp" id="banners" style="position: absolute; top: 0%; left: 0%; width: 100%; visibility: hidden; z-index:2;" />
        <img src="assets/img/webp/good_submit.webp" id="submit" style="position: absolute; top: 0%; left: 0%; width: 100%; visibility: hidden; z-index:2;" />

        <form action="" method="POST" id="formNews" style="visibility: hidden;">
          <input type="text" id="name" placeholder="Your Splendid Name" class="signup" style="outline: none; font-family: Courier New; font-size: 1.0rem; color: #000000ff; background: none; position: absolute; border: none; cursor: text; width:50%; height: 8%; bottom:71%; left:45%; z-index:2;"></input>
          <input type="email" id="email" placeholder="theemailyouuse@mail.com" class="signup" required style="outline: none; font-family: Courier New; font-size: 1.0rem; color: #000000ff; background: none; position: absolute; border: none; cursor: text; width:60%; height: 8%; bottom:53%; left:39%; z-index:2; "></input>
          <input type="submit" id="submitBtn" value="" style="background: none; border: none; position: absolute; top: 81%; left: 43%; height: 14%; width: 33%; cursor: pointer; z-index: 2;"/>
        </form>

        <img src="assets/img/webp/sche_frame.webp" id="sch_frame" style="position: absolute; top: 0%; left: 0%; width: 100%; z-index: 3; visibility: hidden;" />
        <img src="assets/img/webp/sche_text.webp" id="sch_text" style="position: absolute; top: 0%; left: 0%; width: 100%; z-index: 3; visibility: hidden;" />
        <img src="assets/img/webp/sche_text_s.webp" id="sch_text_s" style="position: absolute; top: 0%; left: 0%; width: 100%; z-index: 3; visibility: hidden;" />
        <img src="assets/img/webp/sche_pay.webp" id="sch_pay" style="position: absolute; top: 0%; left: 0%; width: 100%; z-index: 3; visibility: hidden;" />
        <div id="sch_payBtn" style="border: none; cursor: pointer; position:absolute; width:21%; height:14%; bottom:2%; left:65%; z-index:3; visibility: hidden;"></div>
        <img src="assets/img/webp/sche_purchase.webp" id="sch_purchase" style="position: absolute; top: 0%; left: 0%; width: 100%; z-index: 3; visibility: hidden;" />
        <img src="assets/img/webp/sche_purchase_done.webp" id="sch_purchase_done" style="position: absolute; top: 0%; left: 0%; width: 100%; z-index: 3; visibility: hidden;" />
       
        <form action="" id="formPurchase" style="visibility: hidden;">
          <input type="text" id="namePurchase" placeholder="Your Splendid Name" class="signup" style="outline: none; font-family: Courier New; font-size: 1.0rem; color: rgb(255, 255, 255); background: none; position: absolute; border: none; cursor: text; width:39%; height: 8%; bottom:59%; left:30.5%; z-index:4;"></input>
          <input type="email" id="emailPurchase" placeholder="youremail@mail.com" class="signup" required style="outline: none; font-family: Courier New; font-size: 1.0rem; color: rgb(255, 255, 255); background: none; position: absolute; border: none; cursor: text; width:39%; height: 8%; bottom:42%; left:30.5%; z-index:4;"></input>
          <div id="card-element" style="text-align: center; outline: none; font-family: Courier New; background: none; position: absolute; width: 39%; height: 100%; height:4.5%; top: 70%; left:30.5%; transform: rotateZ(0.5deg); max-height: 100%; max-width: 100%; z-index: 4"></div>

          <input type="submit" id="submitPurchase" value="" style="background: none; border: none; position: absolute; top: 85%; left: 29%; height: 11%; width: 39%; cursor: pointer; z-index: 4;"/>
        </form>

        </div>
        </div>
      </div>
    `

    const size = Math.min(document.body.clientWidth, document.body.clientHeight) * 1.2;
    startOrbCanvas(size, size);
    

      const stripe = Stripe('pk_live_');
      const elements = stripe.elements();

      const card = elements.create('card', {
        style: {
          base: {
            color: 'rgb(255, 255, 255)', 
            fontSize: '1.5rem', 
            fontFamily: 'system-ui, sans-serif',
          }
        }
      });

      card.mount('#card-element');

      const form = document.getElementById('formPurchase');

      form.addEventListener('submit', async (e) => {
        e.preventDefault();

        submit.src = "assets/img/webp/sche_purchase_done.webp";
        setTimeout(function() {
        submit.src = "assets/img/webp/sche_purchase_donehl.webp";
        }, 200);
        const email = document.getElementById('emailPurchase').value;
        const message = document.getElementById('namePurchase').value;
        const option = 'scheherezade';
        const tale = `scheherezade`;

        const res = await fetch('/create-payment-intent.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email, message, option, tale })
        });

        const { clientSecret, error } = await res.json();
        if (error) {
          document.getElementById('error-message').textContent = error;
          return;
        }

        const result = await stripe.confirmCardPayment(clientSecret, {
          payment_method: {
            card,
            billing_details: { email }
          }
        });

        if (result.error) {
          document.getElementById('error-message').textContent = result.error.message;
        } else {
          window.location.href = '/';
        }
      });

    const backBtn = document.getElementById(`buttonBack`);
    backBtn.onclick = () => {
      renderMainUI();
    };

      const submit = document.getElementById(`submit`);
      const submitBtn = document.getElementById(`submitBtn`);
      // if(scroll) search.value = scroll;
      // const submit = document.getElementById(`submit`);
      submitBtn.onclick = () => {
        submit.src = "assets/img/webp/good_submit_down.webp";
        setTimeout(function() {
        submit.src = "assets/img/webp/good_submit.webp";
        }, 200);
      };

    const letter = document.getElementById(`letter`);
    const letterHL = document.getElementById(`letterHL`);
    const shright = document.getElementById(`shright`);
    const shrightHL = document.getElementById(`shrightHL`);
    const shleft = document.getElementById(`shleft`);
    const shleftHL = document.getElementById(`shleftHL`);
    const shbig = document.getElementById(`shbig`);
    const shbigHL = document.getElementById(`shbigHL`);
    const glass = document.getElementById(`glass`);
    const glassHL = document.getElementById(`glassHL`);
    const swan = document.getElementById(`swan`);
    const swanHL = document.getElementById(`swanHL`);
    const statue = document.getElementById(`statue`);
    const statueHL = document.getElementById(`statueHL`);
    
    const sch_statue = document.getElementById(`sch_statue`);
    const sch_text = document.getElementById(`sch_text`);
    const sch_text_s = document.getElementById(`sch_text_s`);
    const sch_frame = document.getElementById(`sch_frame`);
    const sch_pay = document.getElementById(`sch_pay`);
    const sch_payBtn = document.getElementById(`sch_payBtn`);

    const sch_purchase = document.getElementById(`sch_purchase`);
    const sch_purchase_done = document.getElementById(`sch_purchase_done`);
    const formPurchase = document.getElementById(`formPurchase`);

    const textmouse = document.getElementById(`textmouse`);
    const mouseSays = document.getElementById(`mouseSays`);

    const bubble = document.getElementById(`bubble`);
    const text = document.getElementById(`text`);
    const yes = document.getElementById(`yes`);
    const no = document.getElementById(`no`);
    const yesBtn = document.getElementById(`yesBtn`);
    const noBtn = document.getElementById(`noBtn`);

    const banners = document.getElementById(`banners`);

    const formNews = document.getElementById(`formNews`);
    const name = document.getElementById(`name`);
    const email = document.getElementById(`email`);

    statue.onmousedown = () => {
      textmouse.style.visibility = "hidden";
      statue.style.visibility = "hidden";

      sch_statue.src = "assets/img/webp/sche_statue.webp";
      sch_frame.style.visibility = "visible";
      sch_text.style.visibility = "visible";
      sch_text_s.style.visibility = "visible";
      sch_pay.style.visibility = "visible";
      sch_payBtn.style.visibility = "visible";
    }
    sch_payBtn.onmousedown = () => {
      sch_purchase.style.visibility = "visible";
      sch_purchase_done.style.visibility = "visible";
      formPurchase.style.visibility = "visible";

      sch_frame.style.visibility = "hidden";
      sch_text.style.visibility = "hidden";
      sch_text_s.style.visibility = "hidden";
      sch_pay.style.visibility = "hidden";
      sch_payBtn.style.visibility = "hidden";
    }
    shright.onmousedown = () => {
      mouseSays.innerHTML = 'Whyever are there so many shells — does the Wizard use them for some spell? But, inexorably, your attention is drawn back to the statuette…'
    }
    shleft.onmousedown = () => {
      mouseSays.innerHTML = 'Whyever are there so many shells — does the Wizard use them for some spell? But, inexorably, your attention is drawn back to the statuette…'
    }
    shbig.onmousedown = () => {
      mouseSays.innerHTML = 'A very attractive specimen of erstwhile nautilus! And yet… why do you feel such a strong urge to touch the little yellow statue?'
    }
    glass.onmousedown = () => {
      mouseSays.innerHTML = 'Suddenly your throat is parched, though this glass remains empty: and the little statue continues to beckon…'
    }
    swan.onmousedown = () => {
      mouseSays.innerHTML = 'Fine craftsmanship, this — but you cannot look more closely upon the swan, as your fingers are simply itching to touch that strange figurine!'
    }
    letter.onmousedown = () => {
      textmouse.style.visibility = "hidden";
      bubble.style.visibility = "visible";
      text.style.visibility = "visible";
      yes.style.visibility = "visible";
      no.style.visibility = "visible";
        banners.style.visibility = "hidden";
        submit.style.visibility = "hidden";
        submitBtn.style.visibility = "hidden";
        formNews.style.visibility = "hidden";
      yesBtn.onmousedown = () => {
        text.style.visibility = "hidden";
        yes.style.visibility = "hidden";
        no.style.visibility = "hidden";
        banners.style.visibility = "visible";
        submit.style.visibility = "visible";
        submitBtn.style.visibility = "visible";
        formNews.style.visibility = "visible";
      };
      noBtn.onmousedown = () => {
        mouseSays.innerHTML = "On the far side of the Wizard's writing—desk stands a yellow statuette you have no choice but to reach out and touch...";
        textmouse.style.visibility = "visible";
        bubble.style.visibility = "hidden";
        text.style.visibility = "hidden";
        yes.style.visibility = "hidden";
        no.style.visibility = "hidden";
      };
    };
    
    formPurchase.onmouseover = () => {
      sch_purchase_done.src="assets/img/webp/sche_purchase_donehl.webp";
    };
    formPurchase.onmouseout = () => {
      sch_purchase_done.src="assets/img/webp/sche_purchase_done.webp";
    };
    sch_payBtn.onmouseover = () => {
      sch_pay.src = "assets/img/webp/sche_payhl.webp";
    };
    sch_payBtn.onmouseout = () => {
      sch_pay.src = "assets/img/webp/sche_pay.webp";
    };
    letter.onmouseover = () => {
      letterHL.style.visibility = "visible";
    };
    letter.onmouseout = () => {
      letterHL.style.visibility = "hidden";
    };
    shright.onmouseout = () => {
      shrightHL.style.visibility = "hidden";
    };
    shright.onmouseover = () => {
      shrightHL.style.visibility = "visible";
    };
    shleft.onmouseout = () => {
      shleftHL.style.visibility = "hidden";
    };
    shleft.onmouseover = () => {
      shleftHL.style.visibility = "visible";
    };
    shbig.onmouseout = () => {
      shbigHL.style.visibility = "hidden";
    };
    shbig.onmouseover = () => {
      shbigHL.style.visibility = "visible";
    };
    glass.onmouseout = () => {
      glassHL.style.visibility = "hidden";
    };
    glass.onmouseover = () => {
      glassHL.style.visibility = "visible";
    };
    swan.onmouseout = () => {
      swanHL.style.visibility = "hidden";
    };
    swan.onmouseover = () => {
      swanHL.style.visibility = "visible";
    };
    statue.onmouseout = () => {
      statueHL.style.visibility = "hidden";
    };
    statue.onmouseover = () => {
      statueHL.style.visibility = "visible";
    };
  }

  </script>
</html>

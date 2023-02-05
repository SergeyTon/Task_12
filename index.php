<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Чайлд Ли Джекович',
        'job' => 'writer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
    [
        'fullname' => 'Сталлоне Сильвестр Селиверстович',
        'job' => 'actor',
    ],
];


function getRandomFullname($arr) { 
    $i = rand(0, (count($arr)-1));
    return $arr[$i]['fullname'];
}

$fullname = getRandomFullname($example_persons_array); 


// разбиение фио

function getPartsFromFullname($string) {    
	$named_keys = ['surname', 'name', 'patronomyc'];
	$persons_fullname_array = array_combine($named_keys, explode(' ', $string));
	return $persons_fullname_array;
}

$result = getPartsFromFullname($fullname);   
print_r($result);

// сборка фио
function getFullnameFromParts($surname, $name, $patronomyc) {
	return $surname.' '.$name.' '.$patronomyc;
}

$surname = $result['surname'];  
$name = $result['name'];
$patronomyc = $result['patronomyc'];
$string = getFullnameFromParts($surname, $name, $patronomyc);
echo "\n{$string}\n";

// укорачивание имени
function getShortName($string) { 
    
	$arr = getPartsFromFullname($string);
    	$short_name = $arr['name'];
	$short_surname = mb_substr($arr['surname'], 0, 1);
	return $short_name .' '. $short_surname .'.';
}

$getShortName = 'getShortName';
echo "\n{$getShortName($string)}\n";

// определение пола по имени

function getGenderFromName($string) {
	$gender = 'Пол: ';
	$gender_sign = 0;
	$fullname_arr = getPartsFromFullname ($string);
	$surname_end = mb_substr($fullname_arr['surname'], -1, 1);
	$name_end = mb_substr($fullname_arr['name'], -1, 1);
	$patronomyc_end = mb_substr($fullname_arr['patronomyc'], -2, 2);
 
	if  ($surname_end === 'а' || $name_end === 'а' || $patronomyc_end === 'на') {
		$gender_sign -= 1;
	} elseif ($surname_end === 'в' || $name_end === 'н' || $patronomyc_end === 'ич') {
		$gender_sign += 1;
	}

	if (($gender_sign <=> 0) == 1) {
	 	$gender .= 'мужской';
	 } elseif (($gender_sign <=> 0) == -1) {
	 	$gender .= 'женский';
	 } else {
	 	$gender .= 'не определен';	
	 }
 
	return $gender;
}

$getGenderFromName = 'getGenderFromName';
echo "\n{$getGenderFromName($string)}\n";
function percent_count($gender_array, $arr) {
	$percent = round((count($gender_array)/count($arr))*100, 1).'%';
	return $percent;
}

// определение полового состава
function getGenderDescription($arr) {
// получим массив с мужскими именами
	$men_array = array_filter($arr, function ($value) {
	if (getGenderFromName($value['fullname']) === 'Пол: мужской'){
		return $value;
	}
	});
// получим массив с женскими именами
	$women_array = array_filter($arr, function ($value) {
	if (getGenderFromName($value['fullname']) === 'Пол: женский'){
		return $value;
	}
	});
// получим массив с именами, пол которых не определен
	$noGender_array = array_filter($arr, function ($value) {
	if (getGenderFromName($value['fullname']) === 'Пол: не определен'){
		return $value;
	}
	});
	$men_percent = percent_count($men_array, $arr); 
	$women_percent = percent_count($women_array, $arr);
	$noGender_percent = percent_count($noGender_array, $arr);

echo "\n
Гендерный состав аудитории:
__________________________ \n
Мужчины - {$men_percent}
Женщины - {$women_percent}
Не удалось определить - {$noGender_percent}";
}

print_r(getGenderDescription($example_persons_array));



function rightCase($word) {
	$word = mb_convert_case($word, MB_CASE_TITLE_SIMPLE);
	return $word;
}

// подсчет рандомных процентов идеальности
function getPerfectPercent() {
	$max_percent = 100;
	$current_percent = rand(50, 100).'.'.rand(0, 9).rand(0, 9);
	if ($current_percent > $max_percent)
	return $max_percent.'.'.'00';
	else return $current_percent;
}


// подбор идеальной пары
function getPerfectPartner($surname, $name, $patronomyc, $arr) {
	$first_partner_surname = rightCase($surname);
	$first_partner_name = rightCase($name);
	$first_partner_patronomyc = rightCase($patronomyc);
	$first_partner_fullname = getFullnameFromParts($first_partner_surname, $first_partner_name, $first_partner_patronomyc);
	$first_partner_gender = getGenderFromName($first_partner_fullname);
	while ($first_partner_gender === 'Пол: не определен'){
	$first_partner_fullname = getRandomFullname($arr);
	$first_partner_gender = getGenderFromName($first_partner_fullname);
	}
	$second_partner_name = getRandomFullname($arr);
	$second_partner_gender = getGenderFromName($second_partner_name);
	while ($second_partner_gender === $first_partner_gender || $second_partner_gender === 'Пол: не определен') {
	$second_partner_name = getRandomFullname($arr);
	$second_partner_gender = getGenderFromName($second_partner_name);
	}
	$second_partner_fullname = rightCase($second_partner_name);
	$first_partner_short_name = getShortName($first_partner_fullname);
	$second_partner_short_name = getShortName($second_partner_fullname);
	$perfect_percent = getPerfectPercent().'%';
echo "\n\n";
echo "{$first_partner_short_name} + {$second_partner_short_name} = ♡ Идеально на {$perfect_percent} ♡";
}
print_r(getPerfectPartner($surname, $name, $patronomyc, $example_persons_array)."\n");
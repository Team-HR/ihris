<?php
require "_connect.db.php";


// $sql = "SELECT * FROM employees order by firstname asc";
// $result = $mysqli->query($sql);
// echo "<table>";
// while($row = $result->fetch_assoc())
// {
    
//     $employees_id = $row["employees_id"];
//     $firstName = $row["firstName"];
//     $lastName = $row["lastName"];
//     $middleName = $row["middleName"]?$row["middleName"][0].".":".";
//     $extName = $row["extName"];
//     $full_name = $firstName." ".($middleName===".."?".":$middleName)." ".$lastName." ".$extName;
//     echo "<tr>";
//     echo "<td>".$employees_id."</td><td>".$full_name."</td>";
//     echo "</tr>";
// }
// echo "</table>";



// $employee_ids = array(1=>21202,7=>31777,12=>32221,15=>21456,17=>21108,20=>32211,21=>21242,23=>22116,24=>31437,26=>31980,31=>1214,33=>21952,37=>21270,38=>32034,40=>21029,22118=>31997,47=>31284,48=>31740,50=>32263,64=>21833,22167=>22167,67=>21440,68=>31226,69=>31428,74=>31330,75=>31803,76=>21661,80=>31066,83=>21647,85=>21155,86=>21184,90=>32157,91=>32124,92=>32148,97=>21781,99=>31463,102=>42006,110=>32218,22135=>31948,118=>32164,124=>21063,125=>21291,128=>32095,133=>21729,143=>21201,144=>21294,151=>21483,22168=>999991,152=>21037,153=>21804,154=>31818,156=>32060,164=>31628,165=>32149,166=>22088,172=>21555,173=>31540,22132=>21172,181=>21187,182=>21035,183=>22110,184=>32159,187=>21312,189=>21516,195=>21655,196=>21405,197=>21500,198=>31579,199=>21964,202=>31336,207=>21141,22170=>22170,212=>22248,221=>31768,22119=>32267,227=>21662,228=>21139,231=>21951,235=>32030,237=>32035,22153=>22153,240=>21504,241=>21314,249=>31563,252=>21760,253=>31754,256=>31834,261=>32150,266=>21142,267=>31899,269=>31297,271=>21442,272=>21193,274=>21247,278=>32126,279=>21930,284=>21236,22149=>32278,286=>21725,290=>22235,292=>31511,298=>42105,22148=>32277,304=>21747,22185=>42309,22150=>22279,306=>31629,312=>42217,319=>31030,320=>31127,322=>21705,324=>21553,326=>32256,22115=>22115,331=>32059,332=>21380,340=>21570,341=>31024,342=>21731,345=>21084,347=>21181,348=>21327,349=>21305,353=>32140,355=>21932,22159=>22159,357=>21266,361=>31306,364=>21363,365=>21793,370=>42199,377=>21543,378=>32068,22175=>22299,380=>42241,381=>370,383=>22061,386=>21786,389=>22056,398=>21489,399=>31987,400=>11897,402=>31688,22154=>32287,419=>21743,424=>31506,425=>32238,426=>32065,427=>21246,431=>21438,437=>32189,22183=>42308,444=>21334,450=>31150,22136=>32127,456=>31429,457=>21609,460=>31490,465=>31783,466=>22236,467=>32145,469=>22066,470=>21673,22151=>32285,472=>22161,474=>21572,475=>22000,476=>41011,480=>21462,481=>21772,482=>21189,485=>32093,490=>31985,491=>21274,492=>21615,495=>21057,496=>21147,497=>21143,498=>31366,500=>21263,502=>21354,22163=>22163,511=>21831,516=>31835,519=>31934,522=>21919,527=>21663,528=>21036,529=>31942,530=>32237,531=>21924,535=>21678,536=>31393,539=>21212,545=>32602,546=>21395,548=>32152,552=>21433,554=>32037,568=>21796,571=>22240,576=>21093,22125=>41630,579=>21441,587=>31401,588=>21451,590=>22087,592=>21474,593=>31449,596=>21275,598=>21049,602=>999994,603=>21657,604=>32253,607=>21616,608=>21273,616=>21920,618=>21517,619=>11894,627=>21664,628=>22154,22127=>32252,630=>21716,631=>22019,632=>21025,634=>31937,636=>1605,637=>31089,639=>32091,645=>21567,646=>22204,647=>21949,648=>21654,652=>21505,655=>21144,656=>21159,664=>21425,666=>31947,22116=>32181,669=>21341,673=>32129,22147=>999932281,681=>21521,692=>21634,693=>21821,694=>21491,698=>32207,702=>21039,703=>21418,705=>21408,706=>31999,714=>21455,715=>31333,716=>21728,724=>21909,726=>21819,727=>21223,728=>31809,22179=>22305,731=>31906,734=>32227,735=>22012,737=>31923,741=>21667,743=>31830,745=>21588,752=>31131,755=>31618,757=>21649,760=>21687,761=>21166,762=>32120,766=>32025,767=>22049,768=>32131,770=>32176,774=>32246,776=>1419,778=>31986,22164=>22164,782=>21533,22165=>1166,790=>21056,796=>21900,802=>21403,804=>22050,22123=>22027,814=>31627,817=>124,818=>21454,819=>21323,21828=>21828,22160=>22295,826=>42102,834=>31376,835=>22003,836=>11958,838=>31671,840=>21910,841=>31507,846=>31268,847=>32137,851=>32166,852=>31837,860=>21554,861=>21180,22124=>32266,864=>32031,866=>21645,868=>21601,869=>31676,872=>21129,873=>22073,875=>21407,22146=>32283,879=>32216,882=>21042,883=>11896,888=>32071,22143=>32284,893=>21582,894=>21105,895=>31802,898=>31998,908=>21124,920=>21174,922=>21027,926=>21611,928=>22210,935=>21345,942=>21156,943=>31965,22137=>32015,946=>999997,949=>21233,953=>21328,957=>21206,959=>21612,22184=>42311,22139=>32282,965=>31703,969=>42214,972=>31285,977=>22215,982=>31528,22121=>32265,22176=>22301,988=>21265,990=>32094,993=>31619,994=>21289,995=>31411,996=>31994,998=>998,1009=>21046,1010=>22038,1012=>22042,1013=>32143,1017=>32132,1020=>32036,1022=>32250,1025=>21552,1044=>31390,1045=>21138,1047=>21738,1048=>21774,1051=>999998,1054=>31237,1055=>21185,1057=>21635,1058=>31481,1059=>22234,1060=>31028,1065=>32086,1073=>32160,22172=>22294,1085=>31475,1087=>21335,1089=>32051,1091=>22183,1094=>22259,1106=>21929,1108=>11914,22117=>22270,1112=>21302,1113=>31450,1114=>21136,1115=>31682,1116=>21549,1117=>31445,1122=>21162,1126=>21826,1130=>21213,1131=>31259,1132=>21446,1136=>22108,1137=>31541,1138=>21624,1141=>31530,1142=>21547,1143=>31546,1144=>32151,1145=>21135,22178=>42307,1154=>21161,1156=>21706,1157=>21204,1158=>21208,1159=>31470,1160=>21707,1161=>32024,1162=>21457,1163=>21086,1164=>21349,1165=>21324,1166=>32192,1168=>21792,1169=>21374,1172=>21210,1174=>32165,1180=>31426,1184=>22101,22171=>22171,1188=>31058,1193=>21216,1196=>32118,1198=>31221,1199=>21416,1200=>31755,1201=>21196,1207=>21353,1209=>21512,1210=>1430,1215=>21249,1216=>21419,1222=>32208,1223=>21250,1226=>21371,1231=>21918,1233=>31251,1246=>21672,1253=>21928,22064=>22064,1260=>21145,1263=>21173,1264=>21816,1267=>21072,22155=>22272,1271=>22187,1275=>21599,1281=>21325,1291=>32247,1292=>21485,1295=>21602,1296=>32069,1298=>22082,1300=>31708,1301=>32096,1303=>21130,1305=>22213,1308=>21622,1314=>31559,1315=>32223,1318=>21472,1320=>31043,1322=>31367,1324=>32122,1326=>22058,1327=>32174,1330=>21684,1331=>31577,1337=>21436,1340=>21762,1341=>32139,1343=>21508,1345=>32114,1346=>21832,1347=>21779,1348=>21103,1349=>21606,1355=>32052,1357=>31991,1358=>21386,1359=>21050,1360=>21566,22166=>22166,1363=>21368,22180=>22306,1369=>21794,1374=>21234,1376=>31957,1378=>21681,1380=>21107,1382=>21723,22157=>32286,1391=>21583,1392=>32209,1396=>42104,1398=>21252,1399=>32185,1402=>22090,1403=>21730,1404=>21478,1407=>31561,1410=>21077,1411=>21617,1412=>21744,1413=>21243,1414=>21023,1416=>21052,1417=>21800,1418=>21926,1422=>31766,1423=>21300,1426=>21650,1428=>21085,1431=>32180,22161=>22131,1434=>32133,1435=>21668,1438=>31759,1439=>21484,1443=>31510,1445=>21592,1446=>31522,1447=>32142,1448=>21365,1449=>32117,1451=>21763,1452=>21051,1453=>21795,1455=>32198,1458=>21230,1459=>21031,1460=>21658,1461=>32173,1462=>21253,22174=>22300,1471=>21488,1472=>32078,1474=>21286,1476=>21119,1477=>432167,1478=>21412,1483=>32155,1488=>21359,1492=>31045,1493=>32226,1494=>21482,1495=>21254,1496=>31565,1499=>32244,1501=>21493,1502=>21556,1506=>999999,22131=>32067,22173=>42296,1517=>32158,1519=>21110,1520=>21812,1526=>31217,1527=>31822,1541=>32188,22133=>21806,1543=>21637,1545=>21539,1547=>22092,1548=>32222,1549=>21421,1555=>21176,1556=>31422,1557=>21132,1562=>21905,1563=>42099,1564=>21593,1565=>21389,1566=>32249,1568=>21765,1569=>21709,1577=>1479,1579=>31387,1580=>32231,1581=>32121,1594=>22080,1596=>31824,1602=>31712,1603=>41983,1604=>21215,1605=>21126,1606=>32191,1607=>31113,1608=>22077,22162=>22162,1609=>21933,1610=>32229,1611=>32206,1613=>31350,1615=>22033,1617=>32242,1618=>21692,1619=>21167,1620=>11977,1621=>32054,1624=>21168,1625=>22233,1626=>22072,1629=>32225,1630=>21070,1639=>21398,1640=>21476,1641=>31542,1642=>32128,1647=>21925,1648=>31961,1652=>21248,1654=>32193,1657=>21406,1658=>32146,1659=>1484,1664=>22047,1665=>21087,1666=>32084,1668=>21940,1669=>1669,1670=>21100,1672=>32254,1675=>21494,1683=>21764,1684=>21091,1685=>31642,1686=>32085,1688=>21518,1689=>31209,1690=>21477,1691=>21413,1695=>31585,1698=>21499,1702=>21536,1703=>21726,1704=>21584,22138=>32271,22145=>32280,1707=>21444,1708=>21665,1712=>31224,1717=>32079,1718=>21195,1720=>31903,1729=>31114,22141=>31982,1732=>32109,1738=>22074,1745=>11010,1746=>32029,1752=>21083,1761=>31116,1762=>1000,22181=>252,1764=>21414,1767=>21639,1770=>32028,1772=>21525,1778=>32251,1781=>31310,1788=>31666,1791=>22018,1792=>21316,1794=>31133,1796=>32245,1800=>31922,1805=>32179,1807=>31749,1809=>21420,1811=>32205,1812=>22220,1816=>21479,1822=>31674,22128=>32264,22156=>32273,1833=>32044,1842=>31996,1844=>31838,1845=>31938,1849=>22048,1850=>22194,1852=>31955,1853=>21320,1857=>32070,1859=>31652,1861=>31979,1863=>21101,1865=>21514,1872=>21573,1875=>32228,1877=>21311,1888=>21186,1890=>21580,1892=>32144,1895=>21111,1897=>22083,1898=>32184,1899=>32075,1904=>21170,1905=>21432,1906=>32026,1914=>31748,1915=>22232,1916=>31240,1922=>31018,1924=>32057,1929=>21495,1931=>1167,1935=>21423,1936=>21827,1937=>21562,1941=>31597,1942=>31954,1949=>21282,1952=>31916,22130=>22013,1960=>21575,1963=>21448,1966=>31214,1967=>32243,1968=>21745,1970=>21532,1978=>31944,1980=>31283,1981=>21778,1990=>31358,1991=>32134,1994=>31756,1997=>32141,2007=>21544,2008=>21047,2010=>31939,2011=>22200,2012=>32043,2013=>31693,22134=>31701,2021=>32147,2022=>21538,2025=>32182,2026=>21677,2028=>21055,2034=>22053,2035=>2035,2036=>21351,2044=>21357,2049=>31751,2053=>32062,2054=>21355,2055=>42103,2064=>21235,2065=>32255,2067=>31381,2068=>31550,2077=>31750,2079=>31523,2083=>42081,2089=>21590,2093=>31098,2094=>21065,2101=>31231,2110=>21981,2114=>21004,2115=>42100,2118=>21099,2123=>21137,2124=>31545,2125=>31293,2134=>21911,2135=>31758,2136=>31695,2137=>21632,22169=>42002,2145=>31277,2148=>21953,2150=>21537,2155=>31502,2157=>21074,2158=>21019,22152=>22276,22177=>1499,2160=>21702,2162=>31158,2163=>32162,2164=>22097,2165=>11892,2166=>22007,2168=>21097,2169=>21369,2171=>21272,2172=>32130,2174=>22195,2175=>21581,2177=>21950,2178=>21497,2180=>32123,2181=>21776,2182=>21907,2184=>21404,2185=>21197,22182=>22292,2194=>21501,2196=>21697,2197=>21360,2198=>21075,22142=>32281,2203=>21317,2205=>21303,2206=>32136,2207=>21290,2208=>21244,2213=>21106,2214=>32186,2216=>21727,2221=>21670,2222=>21194,2223=>21603,2224=>21225,22120=>32268,2227=>2227,2234=>2234,2230=>32125,2232=>31515,2233=>22201,2235=>1833,2236=>31487,2241=>22258,2244=>32177,2246=>32178,2251=>22119,2252=>21399,2253=>21805,2256=>21179,2258=>21653,2259=>21548,2263=>21329,2264=>32153,2265=>32107,2269=>21643,2271=>31151,2272=>21348,2275=>21340,2276=>32257,2277=>22156,2279=>22020,2281=>21714,2282=>31464,2287=>21356,2288=>21551,2289=>42005,2290=>21157,2291=>21183,2294=>21134,2295=>22032,2297=>21811,2299=>21068,2301=>21468,2304=>31435,2306=>21660,2307=>21278,2309=>31810,2310=>32197,2311=>21424,2313=>22239,2314=>21427,2316=>21388,2319=>21260,2320=>21669,2327=>21279,2328=>31613,2336=>21742,2338=>21946,2339=>21453,2343=>21921,2345=>32196,2348=>31232);
// echo count($employee_ids);

// foreach ($employee_ids as $old_id => $new_id){
//     // echo $old_id."=>".$new_id."<br>";
//     $sql = "UPDATE 
//     -- `ihris_new`.`pds_trainings` 
//     -- `ihris_new`.`pds_voluntaries` 
//     -- `ihris_new`.`personnelcompetencies` 
//     -- `ihris_new`.`personneltrainingslist` 
//     -- `ihris_new`.`prrlist` 
//     -- `ihris_new`.`requestandcomslist` 
//     -- `ihris_new`.`rnr_recognitions` 
//     `ihris_new`.`spms_feedbacking` 
//      SET feedbacking_emp = '$new_id' WHERE feedbacking_emp = '$old_id'";
//     $mysqli->query($sql);
// }
// competency pa ko

$employee_ids = array(999991=>1,999994=>2,999997=>3,999998=>4,999999=>5,999932281=>6);

foreach ($employee_ids as $old_id => $new_id){
    $sql = "UPDATE 
    `ihris_new`.`spms_feedbacking` 
     SET feedbacking_emp = '$new_id' WHERE feedbacking_emp = '$old_id'";
    $mysqli->query($sql);

    $sql = "UPDATE 
    `ihris`.`cmremp`
     SET emp_id = '$new_id' WHERE emp_id = '$old_id'";
    $mysqli->query($sql);

    $sql = "UPDATE 
    `ihris`.`competency` 
     SET employees_id = '$new_id' WHERE employees_id = '$old_id'";
    $mysqli->query($sql);
    
    $sql = "UPDATE 
    `ihris`.`corefucndata` 
     SET empId = '$new_id' WHERE empId = '$old_id'";
    $mysqli->query($sql);
    
    $sql = "UPDATE 
    `ihris`.`employees` 
     SET employees_id = '$new_id' WHERE employees_id = '$old_id'";
    $mysqli->query($sql);
    
    $sql = "UPDATE 
    `ihris`.`individualassreport` 
     SET employees_id = '$new_id' WHERE employees_id = '$old_id'";
    $mysqli->query($sql);

    $sql = "UPDATE 
    `ihris`.`ldn_lsa` 
     SET employees_id = '$new_id' WHERE employees_id = '$old_id'";
    $mysqli->query($sql);

    $sql = "UPDATE 
    `ihris`.`pds_children` 
     SET employee_id = '$new_id' WHERE employee_id = '$old_id'";
    $mysqli->query($sql);

    $sql = "UPDATE 
    `ihris`.`pds_educations` 
     SET employee_id = '$new_id' WHERE employee_id = '$old_id'";
    $mysqli->query($sql);
    
    $sql = "UPDATE 
    `ihris`.`pds_eligibilities` 
     SET employee_id = '$new_id' WHERE employee_id = '$old_id'";
    $mysqli->query($sql);

    $sql = "UPDATE 
    `ihris`.`personneltrainingslist` 
     SET employees_id = '$new_id' WHERE employees_id = '$old_id'";
    $mysqli->query($sql);

    $sql = "UPDATE 
    `ihris`.`prrlist`  
     SET employees_id = '$new_id' WHERE employees_id = '$old_id'";
    $mysqli->query($sql);

    $sql = "UPDATE 
    `ihris`.`requestandcomslist` 
     SET employees_id = '$new_id' WHERE employees_id = '$old_id'";
    $mysqli->query($sql);
}

            <div class="ui container" style="width: 1000px; margin-right: auto; margin-left: auto;">
                <canvas id="comptChart"></canvas>
            </div>
            <table class="ui very basic collapsing celled striped table center aligned" style="font-family: Playfair Display; ">
                <tr>
                    <th style="text-align: center;">Competency</th>
                    <th style="text-align: center;">Definition</th>
                    <th style="text-align: center;">Proficiency/Mastery Level</th>
                    <th style="text-align: center;">Behavioral Indicators</th>
                </tr>
                <tr>
                    <td>ADAPTABILITY</td>
                    <td>Adjusting own behaviors to work efficiently and effectively in light of new information, changing situations and/or different environments.</td>
                    <?php
                    if (!empty($serializedComptScore)) {
                        $unserializedComptScore = unserialize($serializedComptScore);
                        // unset($unserializedComptScore[24]);

                        if ($unserializedComptScore[0] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Recognizes how change will affect work.</td>
                            <td>
                            <ul>
                            <li>Accepts that things will change.</li>
                            <li>Seeks clarification when faced with ambiguity or uncertainty.</li>
                            <li>Demonstrates willingness to try new approaches.</li>
                            <li>Suspends judgment; thinks before acting.</li>
                            <li>Acknowledges the value of others’ contributions regardless of how they are presented.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[0] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Adapts one’s work to a situation.</td>
                            <td>
                            <ul>
                            <li>Adapts personal approach to meet the needs of different or new situations.</li>
                            <li>Seeks guidance in adapting behavior to the needs of a new or different situation.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[0] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Adapts to a variety of changes.</td>
                            <td>
                            <ul>
                            <li>Adapts to new ideas and initiatives across a wide variety of issues or situations.</li>
                            <li>Shifts priorities, changes style and responds with new approaches as needed to deal with new or changing demands.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[0] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Adapts to large, complex and/or frequent changes.</td>
                            <td>
                            <ul>
                            <li>Publicly supports and adapts to major/fundamental changes that show promise of improving established ways of operating.</li>
                            <li>Seeks opportunities for change in order to achieve improvement in work processes, systems, etc.</li>
                            <li>Maintains composure and shows self control in the face of challenges and change.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[0] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Adapts to large, complex and/or frequent changes.</td>
                            <td>
                            <ul>
                            <li>Anticipates change and makes large or long-term adaptations in organization in response to the needs of the situation.</li>
                            <li>Performs effectively amidst continuous change, ambiguity and, at times, apparent chaos.</li>
                            <li>Shifts readily between dealing with macro-strategic issues and critical details.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>CONTINUOUS LEARNING</td>
                        <td>Identifying and addressing individual strengths and weaknesses, developmental needs and changing circumstances to enhance personal and organizational performance.</td>
                        <?php
                        if ($unserializedComptScore[1] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Assesses and monitors oneself to maintain personal effectiveness.</td>
                            <td>
                            <ul>
                            <li>Continually self-assesses and seeks feedback from others to identify strengths and weaknesses and ways of improving.</li>
                            <li>Pursues learning opportunities and ongoing development.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[1] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Seeks to improve personal effectiveness in current situation.</td>
                            <td>
                            <ul>
                            <li>Tries new approaches to maximize learning in current situation.</li>
                            <li>Takes advantage of learning opportunities (e.g., courses, observation of others, assignments, etc.).</li>
                            <li>Integrates new learning into work methods.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[1] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Seeks learning opportunities beyond current requirements.</td>
                            <td>
                            <ul>
                            <li>Sets challenging goals and standards of excellence for self in view of growth beyond current job.</li>
                            <li>Actively pursues self-development on an ongoing basis (technically and personally).</li>
                            <li>Pursues assignments designed to challenge abilities.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[1] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Aligns personal development with objectives of organization.</td>
                            <td>
                            <ul>
                            <li>Designs personal learning objectives based on evolving needs of the portfolio or business unit.</li>
                            <li>Uses organizational change as an opportunity to develop new skills and knowledge.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[1] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Aligns personal learning with anticipated change in organizational strategy.</td>
                            <td>
                            <ul>
                            <li>Identifies future competencies and expertise required by the organization and develops and pursues learning plans accordingly.</li>
                            <li>Continuously scans the environment to keep abreast of emerging developments in the broader work context.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>COMMUNICATION</td>
                        <td>Listening to others and communicating in an effective manner that fosters open communication.</td>
                        <?php
                        if ($unserializedComptScore[2] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Listens & clearly presents information.</td>
                            <td>
                            <ul>
                            <li>Makes self available and clearly encourages others to initiate communication.</li>
                            <li>Listens actively and objectively without interrupting.</li>
                            <li>Checks own understanding of others’ communication (e.g., repeats or paraphrases, asks additional questions).</li>
                            <li>Presents appropriate information in a clear and concise manner, both orally and in writing.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[2] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Fosters two-way communication.</td>
                            <td>
                            <ul>
                            <li>Elicits comments or feedback on what has been said.</li>
                            <li>Maintains continuous open and consistent communication with others.</li>
                            <li>Openly and constructively discusses diverse perspectives that could lead to misunderstandings.</li>
                            <li>Communicates decisions or recommendations that could be perceived negatively, with sensitivity and tact.</li>
                            <li>Supports messages with relevant data, information, examples and demonstrations.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[2] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Adapts communication to others.</td>
                            <td>
                            <ul>
                            <li>Adapts content, style, tone and medium of communication to suit the target audience’s language, cultural background and level of understanding.</li>
                            <li>Takes others’ perspectives into account when communicating, negotiating or presenting arguments (e.g., presents benefits from all perspectives).</li>
                            <li>Responds to and discusses issues/questions in an understandable manner without being defensive and while maintaining the dignity of others.</li>
                            <li>Anticipates reactions to messages and adapts communications accordingly.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[2] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Communicates complex messages.</td>
                            <td>
                            <ul>
                            <li>Handles complex on-the-spot questions (e.g., from senior public officials, special interest groups or the media).</li>
                            <li>Communicates complex issues clearly and credibly with widely varied audiences.</li>
                            <li>Uses varied communication systems, methodologies and strategies to promote dialogue and shared understanding.</li>
                            <li>Delivers difficult or unpopular messages with clarity, tact and diplomacy.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[2] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Communicates strategically.</td>
                            <td>
                            <ul>
                            <li>Communicates strategically to achieve specific objectives (e.g., considering such aspects as the optimal message to present, timing and forum of communication).</li>
                            <li>Identifies and interprets departmental policies and procedures for superiors, subordinates and peers.</li>
                            <li>Acknowledges success and the need for improvement.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>ORGANIZATIONAL AWARENESS</td>
                        <td>Understanding the workings, structure and culture of the organization as well as the political, social and economic issues, to achieve results.</td>
                        <?php
                        if ($unserializedComptScore[3] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Understands formal structure.</td>
                            <td>
                            <ul>
                            <li>Monitors work to ensure it aligns with formal procedures and the organization’s accountabilities.</li>
                            <li>Recognizes and uses formal structure, rules, processes, methods or operations to accomplish work.</li>
                            <li>Actively supports the public service mission and goals.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[3] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Understands informal structure and culture.</td>
                            <td>
                            <ul>
                            <li>Uses informal structures; can identify key decision-makers and influencers.</li>
                            <li>Effectively uses both formal and informal channels or networks for acquiring information, assistance and accomplishing work goals.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[3] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Effectively operates in external environments.</td>
                            <td>
                            <ul>
                            <li>Achieves solutions acceptable to varied parties based on understanding of issues, climates and cultures in own and other organizations.</li>
                            <li>Accurately describes the issues and culture of external stakeholders. Uses this information to negotiate goals and initiatives.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[3] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Understands organizational politics, issues and external influences.</td>
                            <td>
                            <ul>
                            <li>Anticipates issues, challenges and outcomes and effectively operates to best position the organization.</li>
                            <li>Supports the changing culture and methods of operating, if necessary, for the success of the organization.</li>
                            <li>Ensures due diligence by keeping informed of business and operational plans and practices.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[3] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Operates effectively in a broad spectrum of political, cultural and social milieu.</td>
                            <td>
                            <ul>
                            <li>Demonstrates broad understanding of social and economic context within which the organization operates.</li>
                            <li>Understands and anticipates the potential trends of the political environment and the impact these might have on the organization.</li>
                            <li>Operates successfully in a variety of social, political and cultural environments.</li>
                            <li>Uses organizational culture as a means to influence and lead the organization.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>CREATIVE THINKING</td>
                        <td>Questioning conventional approaches, exploring alternatives and responding to challenges with innovative solutions or services, using intuition, experimentation and fresh perspectives.</td>
                        <?php
                        if ($unserializedComptScore[4] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Acknowledges the need for new approaches.</td>
                            <td>
                            <ul>
                            <li>Is open to new ideas.</li>
                            <li>Questions the conventional approach and seeks alternatives.</li>
                            <li>Recognizes when a new approach is needed; integrates new information quickly while considering different options.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[4] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Modifies current approaches.</td>
                            <td>
                            <ul>
                            <li>Analyzes strengths and weaknesses of current approaches.</li>
                            <li>Modifies and adapts current methods and approaches to better meet needs.</li>
                            <li>Identifies alternate solutions based on precedent.</li>
                            <li>Identifies an optimal solution after weighing the advantages and disadvantages of alternative approaches.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[4] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Introduces new approaches.</td>
                            <td>
                            <ul>
                            <li>Searches for ideas or solutions that have worked in other environments and applies them to the organization.</li>
                            <li>Uses existing solutions in innovative ways to solve problems.</li>
                            <li>Sees long-term consequences of potential solutions.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[4] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Creates new concepts.</td>
                            <td>
                            <ul>
                            <li>Integrates and synthesizes relevant concepts into a new solution for which there is no previous experience.</li>
                            <li>Creates new models and methods for the organization.</li>
                            <li>Identifies flexible and adaptable solutions while still recognizing professional and organizational standards.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[4] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Nurtures creativity.</td>
                            <td>
                            <ul>
                            <li>Develops an environment that nurtures creative thinking, questioning and experimentation.</li>
                            <li>Encourages challenges to conventional approaches.</li>
                            <li>Sponsors experimentation to maximize potential for innovation.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>NETWORKING/RELATIONSHIP BUILDING</td>
                        <td>Building and actively maintaining working relationships and/or networks of contacts to further the organization’s goals.</td>
                        <?php
                        if ($unserializedComptScore[5] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Accesses sources of information.</td>
                            <td>
                            <ul>
                            <li>Seeks information from others (e.g., colleagues, customers).</li>
                            <li>Maintains personal contacts in other parts of the organization with those who can provide work-related information.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[5] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Builds key contacts.</td>
                            <td>
                            <ul>
                            <li>Seeks out the expertise of others and develops links with experts and information sources.</li>
                            <li>Develops and nurtures key contacts as a source of information.</li>
                            <li>Participates in networking and social events internal and external to the organization.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[5] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Seeks new networking opportunities for self and others.</td>
                            <td>
                            <ul>
                            <li>Seeks opportunities to partner and transfer knowledge (e.g., by actively participating in trade shows, conferences, meetings, committees, multi-stakeholder groups and/or seminars).</li>
                            <li>Cultivates personal networks in different parts of the organization and effectively uses contacts to achieve results.</li>
                            <li>Initiates and develops diverse relationships.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[5] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Strategically expands networks.</td>
                            <td>
                            <ul>
                            <li>Builds networks with parties that can enable the achievement of the organization’s strategy.</li>
                            <li>Brings informal teams of experts together to address issues/needs, share information and resolve differences, as required.</li>
                            <li>Uses knowledge of the formal or informal structure and the culture to further strategic objectives.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[5] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Creates networking opportunities.</td>
                            <td>
                            <ul>
                            <li>Creates and facilitates forums to develop new alliances and formal networks.</li>
                            <li>Identifies areas to build strategic relationships.</li>
                            <li>Contacts senior officials to identify potential areas of mutual, long-term interest.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>CONFLICT MANAGEMENT</td>
                        <td>Preventing, managing and resolving conflicts.</td>
                        <?php
                        if ($unserializedComptScore[6] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Identifies conflict.</td>
                            <td>
                            <ul>
                            <li>Recognizes that there is a conflict between two or more parties.</li>
                            <li>Brings conflict to the attention of the appropriate individual(s).</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[6] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Addresses existing conflict.</td>
                            <td>
                            <ul>
                            <li>Listens to differing points of view and emphasizes points of agreement as a starting point to resolving differences.</li>
                            <li>Openly identifies shared areas of interest in a respectful and timely manner.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[6] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Anticipates and addresses sources of potential conflict.</td>
                            <td>
                            <ul>
                            <li>Anticipates and takes action to avoid/reduce potential conflict (e.g., by encouraging and supporting the various parties to get together and attempt to address the issues themselves).</li>
                            <li>Refocuses teams on the work and end-goals, and away from personality issues.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[6] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Introduces strategies for resolving existing and potential conflict.</td>
                            <td>
                            <ul>
                            <li>Provides consultation to or obtains consultation / mediation for those who share few common interests and who are having a significant disagreement.</li>
                            <li>Introduces innovative strategies for effectively dealing with conflict (e.g., mediation, collaborative and \"mutual gains\" strategies).</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[6] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Creates an environment where conflict is resolved appropriately.</td>
                            <td>
                            <ul>
                            <li>Creates a conflict-resolving environment by anticipating and addressing areas where potential misunderstanding and disruptive conflict could emerge.</li>
                            <li>Models constructive approaches to deal with opposing views when personally challenging the status quo and when encouraging others to do so as well.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>STEWARDSHIP OF RESOURCES</td>
                        <td>Ensures the effective, efficient and sustainable use of government resources and assets (physical, human and financial resources).</td>
                        <?php
                        if ($unserializedComptScore[7] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Uses resources effectively.</td>
                            <td>
                            <ul>
                            <li>Protects and uses resources and assets in a conscientious and effective manner.</li>
                            <li>Identifies wasteful practices and opportunities for optimizing resource use.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[7] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Ensures effective use of resources.</td>
                            <td>
                            <ul>
                            <li>Monitors and ensures the efficient and appropriate use of resources and assets.</li>
                            <li>Explores ways of leveraging funds to expand program effectiveness.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[7] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Controls resource use.</td>
                            <td>
                            <ul>
                            <li>Allocates and controls resources and assets within own area.</li>
                            <li>Implements ways of more effectively utilizing resources and assets.</li>
                            <li>Assigns and communicates roles and accountabilities to maximize team effectiveness; manages workload.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[7] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Implements systems to ensure stewardship of resources.</td>
                            <td>
                            <ul>
                            <li>Identifies gaps in resources that impact on the organization’s effectiveness.</li>
                            <li>Develops strategies to address resource gaps/issues.</li>
                            <li>Ensures alignment of authority, responsibility and accountability with organizational objectives.</li>
                            <li>Ensures that information and knowledge sharing is integrated into all programs and processes.</li>
                            <li>Acts on audit, evaluation and other objective project team performance information.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[7] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Ensures strategic stewardship of resources.</td>
                            <td>
                            <ul>
                            <li>Directs resources to those areas where they will most effectively contribute to long-term goals.</li>
                            <li>Sets overall direction for how resources and assets are to be used in order to achieve the vision and values.</li>
                            <li>Institutes organization-wide mechanisms and processes to promote and support resource management.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>RISK MANAGEMENT</td>
                        <td>Identifying, assessing and managing risk while striving to attain objectives.</td>
                        <?php
                        if ($unserializedComptScore[8] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Identifies possible risks.</td>
                            <td>
                            <ul>
                            <li>Describes risk factors related to a situation/activity.</li>
                            <li>Uses past experience and best practices to identify underlying issues, potential problems and risks.</li>
                            <li>Plans for contingencies.</li>
                            <li>Identifies possible cause-effect relationships.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[8] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Takes calculated risks.</td>
                            <td>
                            <ul>
                            <li>Takes calculated risks with minor, but non-trivial, consequences of error (e.g., risks involving potential loss of some time or money but which can be rectified).</li>
                            <li>Makes decisions based on risk analysis.</li>
                            <li>Makes decisions in the absence of complete information.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[8] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Personally takes significant risks.</td>
                            <td>
                            <ul>
                            <li>Personally takes calculated risks with significant consequences (e.g., significant loss of time or money) but which can be rectified.</li>
                            <li>Anticipates the risks involved in taking action.</li>
                            <li>Identifies possible scenarios regarding outcomes of various options for action.</li>
                            <li>Conducts ongoing risk analysis, looking ahead for contingent liabilities and opportunities and astutely identifying the risks involved.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[8] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Designs strategies for dealing with high-risk initiatives.</td>
                            <td>
                            <ul>
                            <li>Implements initiatives with high potential for pay-off to the organization, where errors cannot be rectified, or only rectified at significant cost.</li>
                            <li>Conducts risk assessment when identifying or recommending strategic and tactical options.</li>
                            <li>Encourages responsible risk taking, recognizing that every risk will not pay off.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[8] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Provides organizational guidance on risk.</td>
                            <td>
                            <ul>
                            <li>Provides a supportive environment for responsible risk taking (e.g., by supporting decisions of others).</li>
                            <li>Oversees the development of guidelines, principles and approaches to assist decision-making when risk is a factor.</li>
                            <li>Provides guidance on the organizational tolerance for risk.</li>
                            <li>Develops broad strategies that reflect in-depth understanding and assessment of operational, organizational, and political realities and risks.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>STRESS MANAGEMENT</td>
                        <td>Maintaining effectiveness in the face of stress.</td>
                        <?php
                        if ($unserializedComptScore[9] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Works in low level stress situations.</td>
                            <td>
                            <ul>
                            <li>Keeps functioning effectively during periods of on-going low intensity stress.</li>
                            <li>Maintains focus during situations involving limited stress.</li>
                            <li>Seeks to balance work responsibilities and personal life responsibilities.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[9] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Adjusts to temporary peaks in stress levels.</td>
                            <td>
                            <ul>
                            <li>Maintains composure when dealing with short but intense stressful situations.</li>
                            <li>Understands personal stressors and takes steps to limit their impact.</li>
                            <li>Keeps issues and situations in perspective and reacts appropriately (e.g., does not overreact to situations, what others say, etc.).</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[9] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Adapts to prolonged stress.</td>
                            <td>
                            <ul>
                            <li>Effectively withstands the effects of prolonged exposure to one or few stressors by modifying work methods.</li>
                            <li>Maintains sound judgment and decision making despite on-going stressful situations.</li>
                            <li>Controls strong emotions or other stressful responses and takes action to respond constructively to the source of the problem.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[9] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Employs stress management strategies.</td>
                            <td>
                            <ul>
                            <li>Develops and applies stress reduction strategies to cope with long exposure to numerous stressors or stressful situations.</li>
                            <li>Recognizes personal limits for workload and negotiates adjustments to minimize the effects of stress, while still ensuring appropriate levels of productivity.</li>
                            <li>Controls own emotions and calms others in stressful situations.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[9] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Deals with stress affecting the organization.</td>
                            <td>
                            <ul>
                            <li>Demonstrates behaviors that help others remain calm, yet focused and energized during periods of extreme stress affecting the organization.</li>
                            <li>Maintains composure and shows self-control in the face of significant challenge facing the organization.</li>
                            <li>Suspends judgment; thinks before acting.</li>
                            <li>Identifies and consistently models ways of releasing or limiting stress within the organization.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>INFLUENCE</td>
                        <td>Gaining support from and convincing others to advance the objectives of the organization.</td>
                        <?php
                        if ($unserializedComptScore[10] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Uses facts and available information to persuade.</td>
                            <td>
                            <ul>
                            <li>Uses appeals to reason, data, facts and figures.</li>
                            <li>Uses concrete examples, visual aids and demonstrations to make a point.</li>
                            <li>Describes the potential impact of own actions on others and how it will affect their perception of self.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[10] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Adapts rationale to influence others.</td>
                            <td>
                            <ul>
                            <li>Anticipates the effect of one’s approach or chosen rationale on the emotions and sensitivities of others.</li>
                            <li>Adapts discussions and presentations to appeal to the needs or interests of others.</li>
                            <li>Uses the process of give-and-take to gain support.</li>
                            <li>Builds relationships through fair, honest and consistent behavior.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[10] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Demonstrates the benefit of ideas.</td>
                            <td>
                            <ul>
                            <li>Builds on successful initiatives and best practices internal and external to the organization to gain acceptance for ideas.</li>
                            <li>Presents pros and cons and detailed analyses to emphasize the value of an idea.</li>
                            <li>Persuades others by drawing from experience and presenting multiple arguments in order to support a position.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[10] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Employs stress management strategiesBuilds coalitions, strategic relationships and networks.</td>
                            <td>
                            <ul>
                            <li>Assembles coalitions, builds behind-the-scenes support for ideas and initiatives.</li>
                            <li>Develops an extensive network of contacts.</li>
                            <li>Uses group process skills to lead or direct a group.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[10] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Designs complex influence strategies.</td>
                            <td>
                            <ul>
                            <li>Designs strategies that position and promote ideas and concepts to stakeholders.</li>
                            <li>Uses indirect strategies to persuade, such as establishing alliances, using experts or third parties.</li>
                            <li>Gains support by capitalizing on understanding of political forces affecting the organization.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>INITIATIVE</td>
                        <td>Identifying and dealing with issues proactively and persistently; seizing opportunities that arise.</td>
                        <?php
                        if ($unserializedComptScore[11] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Addresses current issues.</td>
                            <td>
                            <ul>
                            <li>Recognizes and acts on present issues.</li>
                            <li>Offers ideas to address current situations or issues.</li>
                            <li>Works independently. Completes assignments without constant supervision.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[11] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Addresses imminent issues.</td>
                            <td>
                            <ul>
                            <li>Takes action to avoid imminent problem or to capitalize on imminent opportunity.</li>
                            <li>Looks for ways to achieve greater results or add value.</li>
                            <li>Works persistently as needed and when not required to do so.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[11] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Acts promptly in a crisis situation.</td>
                            <td>
                            <ul>
                            <li>Acts quickly to address a crisis situation drawing on appropriate resources and experience with similar situations.</li>
                            <li>Implements contingency plans when crises arise.</li>
                            <li>Exceeds requirements of job; takes on extra tasks.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[11] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Looks to the future.</td>
                            <td>
                            <ul>
                            <li>Takes action to avoid or minimize potential problems or maximize potential opportunities in the future by drawing on extensive personal experience.</li>
                            <li>Defines and addresses high-level challenges that have the potential to advance the state-of-the art in an area.</li>
                            <li>Starts and carries through on new projects.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[11] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Encourages initiative in others.</td>
                            <td>
                            <ul>
                            <li>Fosters an environment that anticipates and acts upon potential threats and/or opportunities.</li>
                            <li>Coaches others to spontaneously recognize and appropriately act on upcoming opportunities.</li>
                            <li>Gets others involved in supporting efforts and initiatives.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>TEAM LEADERSHIP</td>
                        <td>Leading and supporting a team to achieve results.</td>
                        <?php
                        if ($unserializedComptScore[12] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Keeps the team informed.</td>
                            <td>
                            <ul>
                            <li>Ensures that team members have the necessary information to operate effectively.</li>
                            <li>Establishes the direction/goal(s) for the team.</li>
                            <li>Lets team members affected by a decision know exactly what is happening and gives a clear rationale for the decision.</li>
                            <li>Sets an example for team members (e.g., respect of others’ views, team loyalty, cooperating with others).</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[12] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Ensures the needs of the team and of members are met.</td>
                            <td>
                            <ul>
                            <li>Makes sure the practical needs of the team and team members are met.</li>
                            <li>Makes decisions by taking into account the differences among team members, and overall team requirements and objectives.</li>
                            <li>Ensures that the team’s tasks are completed.</li>
                            <li>Accepts responsibility for the team’s actions and results.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[12] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Ensures team member input.</td>
                            <td>
                            <ul>
                            <li>Values and encourages others’ input and suggestions.</li>
                            <li>Stimulates constructive discussion of different points of view, focusing on the organization’s strategic objectives, vision or values.</li>
                            <li>Builds cooperation, loyalty and helps achieve consensus.</li>
                            <li>Provides constructive feedback and recognizes all contributions.</li>
                            <li>Ensures the respective strengths of team members are used in order to achieve the team’s overall objectives.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[12] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Empowers the team.</td>
                            <td>
                            <ul>
                            <li>Communicates team successes and organization-wide contribution to other organizational members.</li>
                            <li>Encourages the team to promote their work throughout the organization.</li>
                            <li>Establishes the team’s credibility with internal and external stakeholders.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[12] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Inspires team members.</td>
                            <td>
                            <ul>
                            <li>Builds the commitment of the team to the organization’s mission, goals and values.</li>
                            <li>Aligns team objectives and priorities with the broader objectives of the organization.</li>
                            <li>Ensures that appropriate linkages/partnerships between teams are maintained.</li>
                            <li>Creates an environment where team members consistently push to improve team performance and productivity.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>CHANGE LEADERSHIP</td>
                        <td>Managing, leading and enabling the process of change and transition while helping others deal with their effects.</td>
                        <?php
                        if ($unserializedComptScore[13] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Makes others aware of change.</td>
                            <td>
                            <ul>
                            <li>Identifies and accepts the need and processes for change.</li>
                            <li>Explains the process, implications and rationale for change to those affected by it.</li>
                            <li>Invites discussion of views on the change.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[13] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Underscores the positive nature of change.</td>
                            <td>
                            <ul>
                            <li>Promotes the advantages of change.</li>
                            <li>Clarifies the potential opportunities and consequences of proposed changes.</li>
                            <li>Explains how change affects current practices.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[13] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Manages the process for change.</td>
                            <td>
                            <ul>
                            <li>Identifies important / effective practices that should continue after change is implemented.</li>
                            <li>Anticipates specific reasons underlying resistance to change and implements approaches that address resistance.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[13] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Aligns change initiatives with organizational objectives.</td>
                            <td>
                            <ul>
                            <li>Links projects/objectives to department’s/public service’s change initiatives and describes the impact on operational goals.</li>
                            <li>Presents realities of change and, together with staff, develops strategies for managing it.</li>
                            <li>Identifies future needs for change that will promote progress toward identified objectives.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[13] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Champions change.</td>
                            <td>
                            <ul>
                            <li>Creates an environment that promotes and encourages change or innovation.</li>
                            <li>Shares and promotes successful change efforts throughout the organization.</li>
                            <li>Personally communicates a clear vision of the broad impact of change.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>CLIENT FOCUS</td>
                        <td>Identifying and responding to current and future client needs; providing service excellence to internal and external clients.</td>
                        <?php
                        if ($unserializedComptScore[14] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Responds to client requests.</td>
                            <td>
                            <ul>
                            <li>Identifies client needs and expectations.</li>
                            <li>Responds to requests efficiently and effectively.</li>
                            <li>Takes action beyond explicit request within established service standards.</li>
                            <li>Refers complex questions to a higher decision-making level.</li>
                            <li>Meets client needs in a respectful, helpful and responsive manner.</li>
                            <li>Seeks feedback to develop a clear understanding of client needs and outcomes.</li>
                            <li>Uses client satisfaction monitoring methodologies to ensure client satisfaction.</li>
                            <li>Adjusts service based on client feedback.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[14] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Builds positive client Relations.</td>
                            <td>
                            <ul>
                            <li>Contacts clients to follow up on services, solutions or products to ensure that their needs have been correctly and effectively met.</li>
                            <li>Understands issues from the client’s perspective.</li>
                            <li>Keeps clients up-to-date with information and decisions that affect them.</li>
                            <li>Monitors services provided to clients and makes timely adjustments as required.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[14] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Anticipates and adapts to client needs.</td>
                            <td>
                            <ul>
                            <li>Maintains ongoing communication with clients.</li>
                            <li>Regularly and systematically contacts clients or prospective clients to determine their needs.</li>
                            <li>Uses understanding of client’s perspective to identify constraints and advocate on their behalf.</li>
                            <li>Works with clients to adapt services, products or solutions to meet their needs.</li>
                            <li>Encourages co-workers and teams to achieve a high standard of service excellence.</li>
                            <li>Anticipates areas where support or influence will be required and discusses situation/concerns with appropriate individuals.</li>
                            <li>Proposes new, creative and sound alternatives to improve client service.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[14] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Fosters a client-focused culture.</td>
                            <td>
                            <ul>
                            <li>Tracks trends and developments that will affect own organization’s ability to meet current and future client needs.</li>
                            <li>Identifies benefits for clients; looks for ways to add value.</li>
                            <li>Seeks out and involves clients or prospective clients in assessing services, solutions or products to identify ways to improve.</li>
                            <li>Establishes service standards and develops strategies to ensure staff meet them.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[14] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Considers the strategic direction of client focus.</td>
                            <td>
                            <ul>
                            <li>Communicates the organization’s mission, vision and values to external clients.</li>
                            <li>Strategically and systematically evaluates new opportunities to develop client relationships.</li>
                            <li>Creates an environment in which concern for client satisfaction is a key priority.</li>
                            <li>Links a comprehensive and in-depth understanding of clients’ long-term needs and strategies with current and proposed projects/initiatives.</li>
                            <li>Recommends/ determines strategic business direction to meet projected needs of clients and prospective clients.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>PARTNERING</td>
                        <td>Seeking and building strategic alliances and collaborative arrangements through partnerships to advance the objectives of the organization.</td>
                        <?php
                        if ($unserializedComptScore[15] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Operates effectively within partnerships.</td>
                            <td>
                            <ul>
                            <li>Understands the roles played by partners. Identifies and refers to areas of mutual interest as a means of establishing a business relationship.</li>
                            <li>Communicates openly, builds trust and treats partners fairly, ethically and as valued allies.</li>
                            <li>Meets partner needs by responding to requests efficiently and effectively.</li>
                            <li>Recognizes the contributions of partners.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[15] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Manages existing partnerships.</td>
                            <td>
                            <ul>
                            <li>Works with existing partners, honoring established agreements/ contracts.</li>
                            <li>Monitors partnership arrangements to ensure that the objectives of the partnership remain on target.</li>
                            <li>Seeks input from partners to ensure that objectives are achieved.</li>
                            <li>Seeks mutually beneficial solutions with partners.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[15] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Seeks out partnership opportunities.</td>
                            <td>
                            <ul>
                            <li>Initiates partnership arrangements that promote organizational objectives.</li>
                            <li>Assesses the value of entering into partner relationships in terms of both short- and long- term return on investment.</li>
                            <li>Develops new and mutually beneficial partnerships that also serve the interests of the broader community.</li>
                            <li>Identifies benefits of a partnership and looks for ways to add value for the partner.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[15] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Facilitates partnerships.</td>
                            <td>
                            <ul>
                            <li>Provides advice and direction on the types of partner relationships to pursue, as well as ground rules for effective partner relationships.</li>
                            <li>Supports staff in taking calculated risks in partner relationships.</li>
                            <li>Negotiates, as necessary, to assist others to address issues or resolve problems surrounding partner relationships.</li>
                            <li>Identifies when modifications and terminations of partnerships are needed and takes appropriate measures.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[15] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Sets strategic direction for partnering.</td>
                            <td>
                            <ul>
                            <li>Provides strategic direction on partnerships that the organization should be pursuing.</li>
                            <li>Sets up an infrastructure that supports effective partner arrangements (e.g., principles and frameworks for assessing the value of partnerships; expert assistance in aspects of partnering).</li>
                            <li>Takes advantage of opportunities to showcase excellent examples of partner arrangements throughout the organization.</li>
                            <li>Creates and acts on opportunities for interactions that lead to strong partnerships within and external to the organization.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>DEVELOPING OTHERS</td>
                        <td>Fostering the development of others by providing a supportive environment for enhanced performance and professional growth.</td>
                        <?php
                        if ($unserializedComptScore[16] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Shares expertise with others.</td>
                            <td>
                            <ul>
                            <li>Regularly shares expertise with team members to support continuous learning and improvement.</li>
                            <li>Advises, guides and coaches others by sharing experiences and discussing how to handle current or anticipated concerns.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[16] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Supports individual development and improvement.</td>
                            <td>
                            <ul>
                            <li>Provides performance feedback and support, reinforcing strengths and identifying areas for improvement.</li>
                            <li>Encourages staff to develop and apply their skills.</li>
                            <li>Suggests to individuals ways of improving performance and competence.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[16] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Promotes ongoing learning and development.</td>
                            <td>
                            <ul>
                            <li>Helps team members develop their skills and abilities.</li>
                            <li>Engages in development and career planning dialogues with employees.</li>
                            <li>Works with employees and teams to define realistic yet challenging work goals.</li>
                            <li>Encourages team members to develop learning and career plans and follows-up to guide development and measure progress.</li>
                            <li>Advocates and commits to ongoing training and development to foster a learning culture.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[16] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Provides opportunities for development.</td>
                            <td>
                            <ul>
                            <li>Ensures that resources and time are available for development activities.</li>
                            <li>Ensures that all employees have equitable access to development opportunities.</li>
                            <li>Provides opportunities for development through tools, assignments, mentoring and coaching relationships etc.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[16] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Creates a continuous learning and development environment.</td>
                            <td>
                            <ul>
                            <li>Provides long-term direction regarding learning needs for staff and how to pursue the attainment of this learning.</li>
                            <li>Institutes organization-wide mechanisms and processes to promote and support continuous learning and improvement.</li>
                            <li>Manages the learning process to ensure it occurs by design rather than by chance.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>PLANNING AND ORGANIZING</td>
                        <td>Defining tasks and milestones to achieve objectives, while ensuring the optimal use of resources to meet those objectives.</td>
                        <?php
                        if ($unserializedComptScore[17] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Plans tasks and organizes own work.</td>
                            <td>
                            <ul>
                            <li>Identifies requirements and uses available resources to meet own work objectives in optimal fashion.</li>
                            <li>Completes tasks in accordance with plans.</li>
                            <li>Monitors the attainment of own work objectives and/or quality of the work completed.</li>
                            <li>Sets priorities for tasks in order of importance.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[17] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Applies planning principles to achieve work goals.</td>
                            <td>
                            <ul>
                            <li>Establishes goals and organizes work by bringing together the necessary resources.</li>
                            <li>Organizes work according to project and time management principles and processes.</li>
                            <li>Practices and plans for contingencies to deal with unexpected events or setbacks.</li>
                            <li>Makes needed adjustments to timelines, steps and resource allocation.</li>
                            <li>Directs issues to appropriate bodies when unable to resolve them within own area of responsibility.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[17] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Develops plans for the business unit.</td>
                            <td>
                            <ul>
                            <li>Considers a range of factors in the planning process (e.g., costs, timing, customer needs, resources available, etc.).</li>
                            <li>Identifies and plans activities that will result in overall improvement to services.</li>
                            <li>Challenges inefficient or ineffective work processes and offers constructive alternatives.</li>
                            <li>Anticipates issues and revise plans as required.</li>
                            <li>Helps to remove barriers by providing resources and encouragement as needed.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[17] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Integrates and evaluates plans to achieve business goals.</td>
                            <td>
                            <ul>
                            <li>Establishes alternative courses of action, organizes people and prioritizes the activities of the team to achieve results more effectively.</li>
                            <li>Ensures that systems are in place to effectively monitor and evaluate progress.</li>
                            <li>Evaluates processes and results and makes appropriate adjustments to the plan.</li>
                            <li>Sets, communicates and regularly assesses priorities.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[17] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Plans and organizes at a strategic level.</td>
                            <td>
                            <ul>
                            <li>Develops strategic plans considering short-term requirements as well as long-term direction.</li>
                            <li>Plans work and deploys resources to deliver organization-wide results.</li>
                            <li>Secures and allocates program or project resources in line with strategic direction.</li>
                            <li>Sets and communicates priorities within the broader organization.</li>
                            <li>Ensures sufficient resources are available to achieve set objectives.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>DECISION-MAKING</td>
                        <td>Making decisions and solving problems involving varied levels of complexity, ambiguity and risk.</td>
                        <?php
                        if ($unserializedComptScore[18] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Makes decisions based solely on rules.</td>
                            <td>
                            <ul>
                            <li>Makes straightforward decisions based on pre-defined options using clear criteria/procedures.</li>
                            <li>Consults with others or refers an issue/situation for resolution when criteria are not clear.</li>
                            <li>Deals with exceptions within established parameters using clearly specified rules and procedures.</li>
                            <li>Makes decisions involving little or no consequence of error.</li>
                            <li>Verifies that the decision/resolution is correct.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[18] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Makes decisions by interpreting rules.</td>
                            <td>
                            <ul>
                            <li>Applies guidelines and procedures that require some interpretation when dealing with exceptions.</li>
                            <li>Makes straight - forward decisions based on information that is generally clear and adequate.</li>
                            <li>Considers the risks and consequences of action and/or decisions.</li>
                            <li>Makes decisions involving minor consequence of error.</li>
                            <li>Seeks guidance as needed when the situation is unclear.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[18] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Makes decisions in situations where there is scope for interpretation of rules.</td>
                            <td>
                            <ul>
                            <li>Applies guidelines and procedures that leave considerable room for discretion and interpretation.</li>
                            <li>Makes decisions by weighing several factors, some of which are partially defined and entail missing pieces of critical information.</li>
                            <li>As needed, involves the right people in the decision-making process.</li>
                            <li>Balances the risks and implications of decisions across multiple issues.</li>
                            <li>Develops solutions that address the root cause of the problem and prevent recurrence.</li>
                            <li>Recognizes, analyzes and solves problems across projects and in complex situations.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[18] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Makes complex decisions in the absence of rules.</td>
                            <td>
                            <ul>
                            <li>Simplifies complex information from multiple sources to resolve issues.</li>
                            <li>Makes complex decisions for which there are no set procedures.</li>
                            <li>Considers a multiplicity of interrelated factors for which there is incomplete and contradictory information.</li>
                            <li>Balances competing priorities in reaching decisions.</li>
                            <li>Develops solutions to problems, balancing the risks and implications across multiple projects.</li>
                            <li>Recommends solutions in an environment of risk and ambiguity.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[18] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Makes high-risk decisions in complex and ambiguous situations.</td>
                            <td>
                            <ul>
                            <li>Makes high-risk strategic decisions that have significant consequences.</li>
                            <li>Balances a commitment to excellence with the best interests of clients and the organization when making decisions.</li>
                            <li>Uses principles, values and sound business sense to make decisions.</li>
                            <li>Makes decisions in a volatile environment in which weight given to any factor can change rapidly.</li>
                            <li>Reaches decisions assuredly in an environment of public scrutiny.</li>
                            <li>Assesses external and internal environments in order to make a well-informed decision.</li>
                            <li>Identifies the problem based on many factors, often complex and sweeping, difficult to define and contradictory (e.g., fiscal responsibility, the public good).</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>ANALYTICAL THINKING</td>
                        <td>Interpreting, linking, and analyzing information in order to understand issues.</td>
                        <?php
                        if ($unserializedComptScore[19] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Analyzes and synthesizes information.</td>
                            <td>
                            <ul>
                            <li>Breaks down concrete issues into parts and synthesizes succinctly.</li>
                            <li>Collects and analyses information from a variety of appropriate sources.</li>
                            <li>Identifies the links between situations and information.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[19] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Identifies critical relationships.</td>
                            <td>
                            <ul>
                            <li>Sees connections, patterns or trends in the information available.</li>
                            <li>Identifies the implications and possible consequences of trends or events.</li>
                            <li>Draws logical conclusions, providing options and recommendations.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[19] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Analyses complex relationships.</td>
                            <td>
                            <ul>
                            <li>Analyses complex situations, breaking each into its constituent parts.</li>
                            <li>Recognizes and assesses several likely causal factors or ways of interpreting the information available.</li>
                            <li>Identifies connections between situations that are not obviously related.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[19] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Applies broad analysis.</td>
                            <td>
                            <ul>
                            <li>Integrates information from diverse sources, often involving large amounts of information.</li>
                            <li>Thinks several steps ahead in deciding on best course of action, anticipating likely outcomes.</li>
                            <li>Develops and recommends policy framework based on analysis of emerging trends.</li>
                            <li>Gathers information from many sources, including experts, in order to completely understand a problem/situation.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[19] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Applies a systems perspective to the analysis of enterprise-wide issues.</td>
                            <td>
                            <ul>
                            <li>Identifies multiple relationships and disconnects in processes in order to identify options and reach conclusions.</li>
                            <li>Adopts a systems perspective, assessing and balancing vast amounts of diverse information on the varied systems and sub-systems that comprise and affect the working environment.</li>
                            <li>Thinks beyond the organization and into the future, balancing multiple perspectives when setting direction or reaching conclusions (e.g., social, economic, partner, stakeholder interests, short- and longterm benefits, national and global implications).</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>RESULTS ORIENTATION</td>
                        <td>Focusing personal efforts on achieving results consistent with the organization’s objectives.</td>
                        <?php
                        if ($unserializedComptScore[20] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Strives to meet work expectations.</td>
                            <td>
                            <ul>
                            <li>Sets goals and works to meet established expectations; maintains performance levels.</li>  
                            <li>Pursues organizational objectives with energy and persistence. Sets high personal standards for performance.</li>  
                            <li>Adapts working methods in order to achieve objectives.</li>
                            <li>Accepts ownership of and responsibility for own work.</li> 
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[20] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Consistently meets established expectations.</td>
                            <td>
                            <ul>
                            <li>Consistently achieves established expectations through personal commitment.</li>
                            <li>Makes adjustments to activities/processes based on feedback.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[20] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Surpasses established expectations.</td>
                            <td>
                            <ul>
                            <li>Exceeds current expectations and pushes for improved results in own performance.</li>
                            <li>Takes on new roles and responsibilities when faced with unexpected changes.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[20] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Seeks out significant challenges.</td>
                            <td>
                            <ul>
                            <li>Seeks significant challenges outside of current job scope.</li>
                            <li>Works on new projects or assignments that add value without compromising current accountabilities.</li>
                            <li>Guides staff to achieve tasks, goals, processes and performance standards.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[20] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Pursues excellence on an organizational level.</td>
                            <td>
                            <ul>
                            <li>Models excellence and motivates fellow organizational members to follow his/her example.</li>
                            <li>Encourages constructive questioning of policies and practices; sponsors experimentation and innovation.</li>
                            <li>Holds staff accountable for achieving standards of excellence and results for the organization.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>TEAMWORK</td>
                        <td>Working collaboratively with others to achieve common goals and positive results.</td>
                        <?php
                        if ($unserializedComptScore[21] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Participates as a team member.</td>
                            <td>
                            <ul>
                            <li>Assumes personal responsibility and follows up to meet commitments to others.</li>
                            <li>Understands the goals of the team and each team member’s role within it.</li>
                            <li>Deals honestly and fairly with others, showing consideration and respect.</li>
                            <li>Willingly gives support to co-workers and works collaboratively rather than competitively.</li>
                            <li>Shares experiences, knowledge and best practices with team members.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[21] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Fosters teamwork.</td>
                            <td>
                            <ul>
                            <li>Assumes responsibility for work activities and coordinating efforts.</li>
                            <li>Promotes team goals.</li>
                            <li>Seeks others’ input and involvement and listens to their viewpoints.</li>
                            <li>Shifts priorities, changes style and responds with new approaches as needed to meet team goals.</li>
                            <li>Suggests or develops methods and means for maximizing the input and involvement of team members.</li>
                            <li>Acknowledges the work of others.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[21] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Demonstrates leadership in teams.</td>
                            <td>
                            <ul>
                            <li>Builds relationships with team members and with other work units.</li>
                            <li>Fosters team spirit and collaboration within teams .</li>
                            <li>Discusses problems/ issues with team members that could affect results.</li>
                            <li>Communicates expectations for teamwork and collaboration.</li>
                            <li>Facilitates the expression of diverse points of view to enhance teamwork.</li>
                            <li>Capitalizes on the strengths of all members.</li>
                            <li>Gives credit for success and acknowledges contributions and efforts of individuals to team effectiveness.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[21] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Capitalizes on teamwork opportunities.</td>
                            <td>
                            <ul>
                            <li>Initiates collaboration with other groups/ organizations on projects or methods of operating.</li>
                            <li>Capitalizes on opportunities and addresses challenges presented by the diversity of team talents.</li>
                            <li>Supports and encourages other team members to achieve objectives.</li>
                            <li>Encourages others to share experience, knowledge and best practices with the team.</li>
                            <li>Encourages the team to openly discuss what can be done to create a solution or alternative.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[21] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Builds bridges between teams.</td>
                            <td>
                            <ul>
                            <li>Facilitates collaboration across the organization and with other organizations to achieve a common goal.</li>
                            <li>Builds strong teams that capitalize on differences in expertise, competencies and background.</li>
                            <li>Breaks down barriers (structural, functional, cultural) between teams, facilitating the sharing of expertise and resources.</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>VALUES AND ETHICS</td>
                        <td>Fostering and supporting the principles and values of the organization and public service as a whole.</td>
                        <?php
                        if ($unserializedComptScore[22] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Demonstrates behaviors consistent with the organization’s values.</td>
                            <td>
                            <ul>
                            <li>Treats others fairly and with respect.</li>
                            <li>Takes responsibility for own work, including problems and issues.</li>
                            <li>Uses applicable professional standards and established procedures, policies and/or legislation when taking action and making decisions.</li>
                            <li>Identifies ethical dilemmas and conflict of interest situations and takes action to avoid and prevent them.</li>
                            <li>Anticipates and prevents breaches in confidentiality and/or security.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[22] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Identifies ethical implications.</td>
                            <td>
                            <ul>
                            <li>Identifies and considers different ethical aspects of a situation when making decisions.</li>
                            <li>Identifies and balances competing values when selecting approaches or recommendations for dealing with a situation.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[22] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Aligns team with organization’s values and ethics.</td>
                            <td>
                            <ul>
                            <li>Fosters a climate of trust within the work team.</li>
                            <li>Implements processes and structures to deal with difficulties in confidentiality and/or security.</li>
                            <li>Ensures that decisions take into account ethics and values of the organization and Public Service as a whole.</li>
                            <li>Interacts with others fairly and objectively.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[22] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Promotes the organization’s values and ethics.</td>
                            <td>
                            <ul>
                            <li>Advises others in maintaining fair and consistent dealings with others and in dealing with ethical dilemmas.</li>
                            <li>Deals directly and constructively with lapses of integrity (e.g., intervenes in a timely fashion to remind others of the need to respect the dignity of others).</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[22] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Exemplifies and demonstrates the organization’s values and ethics.</td>
                            <td>
                            <ul>
                            <li>Defines, communicates and consistently exemplifies the organization’s values and ethics.</li>
                            <li>Ensures that standards and safeguards are in place to protect the organization’s integrity (e.g., professional standards for financial reporting, integrity/ security of information systems).</li>
                            <li>Identifies underlying issues that impact negatively on people and takes appropriate action to rectify the issues (e.g., systemic discrimination).</li>
                            </ul>
                            </td>
                            ";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td>VISIONING AND STRATEGIC DIRECTION</td>
                        <td>Developing and inspiring commitment to a vision of success; supporting, promoting and ensuring alignment with the organization’s vision and values.</td>
                        <?php
                        if ($unserializedComptScore[23] == 1) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 1 (Introductory)</b> - Demonstrates personal work alignment.</td>
                            <td>
                            <ul>
                            <li>Sets personal work goals in line with operational goals of work area.</li>
                            <li>Continually evaluates personal progress and actions to ensure alignment with organizational vision and operational goals.</li>
                            <li>Liaises with others to ensure alignment with the business goals and vision of the organization.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[23] == 2) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 2 (Basic)</b> - Promotes team alignment.</td>
                            <td>
                            <ul>
                            <li>Effectively communicates and interprets the strategic vision to employees within area of responsibility.</li>
                            <li>Clearly articulates and promotes the significance and impact of employee contributions to promoting and achieving organizational goals.</li>
                            <li>Monitors work of team to ensure alignment with strategic direction, vision and values for the organization.</li>
                            <li>Identifies potential future directions for work area in line with vision.</li>
                            <li>Proactively helps others to understand the importance of the strategy and vision.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[23] == 3) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 3 (Intermediate)</b> - Aligns program/operational goals and plans.</td>
                            <td>
                            <ul>
                            <li>Works with teams to set program/operational goals and plans in keeping with the strategic direction.</li>
                            <li>Regularly promotes the organization, its vision and values to clients, stakeholders and partners.</li>
                            <li>Works with staff to set strategic goals for own sector of the organization.</li>
                            <li>Assesses the gap between the current state and desired future direction and establishes effective ways for closing the gap in own sector.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[23] == 4) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 4 (Advanced)</b> - Influences strategic direction.</td>
                            <td>
                            <ul>
                            <li>Foresees obstacles and opportunities for the organization and acts accordingly.</li>
                            <li>Defines issues, generates options and selects solutions, which are consistent with the strategy and vision.</li>
                            <li>Scans, seeks out and assesses information on potential future directions.</li>
                            <li>Provides direction and communicates the vision to encourage alignment within the organization.</li>
                            <li>Energetically and persistently promotes strategic objectives with colleagues in other business lines.</li>
                            </ul>
                            </td>
                            ";
                        } elseif ($unserializedComptScore[23] == 5) {
                            echo "
                            <td style=\"font-style: italic;\"><b>Level 5 (Expert)</b> - Develops vision.</td>
                            <td>
                            <ul>
                            <li>Leads the development of the vision for the organization.</li>
                            <li>Defines and continuously articulates the vision and strategy in the context of wider government priorities.</li>
                            <li>Describes the vision and values in compelling terms to develop understanding and promote acceptance/ commitment among staff and stakeholders.</li>
                            <li>Identifies, conceptualizes and synthesizes new trends or connections between organizational issues and translates them into priorities for the organization.</li>
                            </ul>
                            </td>
                            ";
                        }
                    }
                    ?>
                </tr>
            </table>


            <script>

                <?php 
                if (!empty($unserializedComptScore)) {
                    ?>

                    var ctx = document.getElementById("comptChart");
                    var comptChart = new Chart(ctx, {
                        type: 'horizontalBar',
                        data: {
                            labels: [
                            "Adaptability",
                            "Continous Learning",
                            "Communication",
                            "Organizational Awareness",
                            "Creative Thinking",
                            "Networking/Relationship Building",
                            "Conflict Management",
                            "Stewardship of Resources",
                            "Risk Management",
                            "Stress Management",
                            "Influence",
                            "Initiative",
                            "Team Leadership",
                            "Change Leadership",
                            "Client Focus",
                            "Partnering",
                            "Developing Others",
                            "Planning and Organizing",
                            "Decision Making",
                            "Analytical Thinking",
                            "Results Orientation",
                            "Teamwork",
                            "Values and Ethics",
                            "Visioning and Strategic Direction",
                            ],
                            datasets: [{
                                label: 'Proficiency/Mastery Level',
                                data: 
                                <?php     
                                echo "[";
                                foreach ($unserializedComptScore as $value) {
                                    echo "\"".$value."\",";
                                }
                                echo "]";
                                ?>,
                                backgroundColor: [
                                'rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)','rgba(64, 117, 169, 1)'
                                ],
                                borderColor: [
                                'rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)','rgba(75, 192, 192, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {

                            scales: {
                                xAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Proficiency/Mastery Level'
                                    },
                                    ticks: {
                                        beginAtZero:true,
                                        max: 5,
                                        stepSize: 1
                                    }
                                }]
        },//end of scales
        title: {
            display: true,
            text: "Job Competency Profile"
        },
        legend: {
            display: false
        }
    }
});

            <?php
        }
        ?>
    </script>
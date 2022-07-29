-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2022 at 06:25 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `autoexam`
--

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `examId` int(11) NOT NULL,
  `instituteId` int(11) DEFAULT NULL,
  `studyId` int(11) DEFAULT NULL,
  `majorId` int(11) DEFAULT NULL,
  `subjectId` int(11) DEFAULT NULL,
  `examMode` enum('Manual','Random') DEFAULT NULL,
  `examName` varchar(100) DEFAULT NULL,
  `semester` varchar(12) DEFAULT NULL,
  `examAddedBy` int(11) DEFAULT NULL,
  `examAddedOn` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`examId`, `instituteId`, `studyId`, `majorId`, `subjectId`, `examMode`, `examName`, `semester`, `examAddedBy`, `examAddedOn`) VALUES
(93, 4, 1, 1, 1, 'Manual', 'Quiz 1', 'Term 1', 1, '2022-06-29 18:12:33'),
(94, 4, 1, 1, 1, 'Random', '20220629', NULL, 1, '2022-06-29 18:15:17'),
(95, 4, 1, 1, 1, 'Random', '20220629', NULL, 1, '2022-06-29 18:16:09'),
(96, 4, 1, 1, 1, 'Manual', '20220629', NULL, 1, '2022-06-29 18:16:43'),
(97, 4, 1, 1, 1, 'Random', '20220629', NULL, 1, '2022-06-29 18:17:18'),
(98, 4, 1, 1, 1, 'Random', '20220629', NULL, 1, '2022-06-29 18:17:45'),
(99, 4, 1, 1, 1, 'Random', '20220629', NULL, 1, '2022-06-29 18:18:21'),
(100, 4, 1, 1, 1, 'Manual', NULL, NULL, 1, '2022-06-30 15:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `exam_questions`
--

CREATE TABLE `exam_questions` (
  `examId` int(11) NOT NULL,
  `questionId` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `questionOrder` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exam_questions`
--

INSERT INTO `exam_questions` (`examId`, `questionId`, `score`, `questionOrder`) VALUES
(93, 2, 6, 2),
(93, 5, 10, 1),
(94, 9, 10, 2),
(94, 28, 6, 1),
(95, 10, 4, 2),
(95, 27, 5, 1),
(95, 31, 1, 3),
(96, 2, 6, 1),
(96, 7, 5, 2),
(97, 6, 5, 2),
(97, 8, 2, 1),
(97, 23, 6, 4),
(97, 29, 7, 3),
(98, 3, 3, 1),
(98, 9, 10, 2),
(98, 11, 8, 3),
(98, 30, 5, 4),
(99, 6, 5, 7),
(99, 8, 2, 6),
(99, 20, 5, 2),
(99, 23, 6, 5),
(99, 26, 5, 4),
(99, 28, 6, 3),
(99, 31, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `exam_topics`
--

CREATE TABLE `exam_topics` (
  `examId` int(11) NOT NULL,
  `topicId` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exam_topics`
--

INSERT INTO `exam_topics` (`examId`, `topicId`, `score`) VALUES
(93, 1, NULL),
(94, 1, 16),
(95, 1, 10),
(96, 1, NULL),
(97, 1, 20),
(98, 1, 16),
(99, 1, 30),
(100, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_type`
--

CREATE TABLE `exam_type` (
  `examId` int(11) NOT NULL,
  `question_abbr` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exam_type`
--

INSERT INTO `exam_type` (`examId`, `question_abbr`) VALUES
(93, 'LAQ'),
(93, 'MCQ'),
(93, 'SAQ'),
(94, 'LAQ'),
(94, 'MCQ'),
(94, 'SAQ'),
(95, 'LAQ'),
(95, 'MCQ'),
(95, 'SAQ'),
(96, 'LAQ'),
(96, 'MCQ'),
(96, 'SAQ'),
(97, 'LAQ'),
(97, 'MCQ'),
(97, 'SAQ'),
(98, 'LAQ'),
(98, 'MCQ'),
(98, 'SAQ'),
(99, 'LAQ'),
(99, 'MCQ'),
(99, 'SAQ'),
(100, 'LAQ'),
(100, 'MCQ'),
(100, 'SAQ');

-- --------------------------------------------------------

--
-- Table structure for table `institute`
--

CREATE TABLE `institute` (
  `institute_id` int(11) NOT NULL,
  `institute_name` varchar(100) DEFAULT NULL,
  `instituteAddedBy` int(11) DEFAULT NULL,
  `instituteAddedOn` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `institute`
--

INSERT INTO `institute` (`institute_id`, `institute_name`, `instituteAddedBy`, `instituteAddedOn`) VALUES
(1, 'Primary School', 1, '2022-06-02 09:54:59'),
(2, 'Middle School', 1, '2022-06-02 09:55:05'),
(3, 'High School', 1, '2022-06-02 09:55:11'),
(4, 'University', 1, '2022-06-02 09:55:24');

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE `major` (
  `major_id` int(11) NOT NULL,
  `major_name` text DEFAULT NULL,
  `type_of_study_id` int(11) DEFAULT NULL,
  `majorAddedBy` int(11) DEFAULT NULL,
  `majorAddedOn` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`major_id`, `major_name`, `type_of_study_id`, `majorAddedBy`, `majorAddedOn`) VALUES
(1, 'Computer Engineering', 1, 1, '2022-06-02 09:57:17'),
(2, 'Biological Sciences', 1, 1, '2022-06-02 09:57:37');

-- --------------------------------------------------------

--
-- Table structure for table `question_bank`
--

CREATE TABLE `question_bank` (
  `question_id` int(11) NOT NULL,
  `subject_topic_id` int(11) DEFAULT NULL,
  `question_abbr` varchar(30) DEFAULT NULL,
  `question` longtext NOT NULL,
  `optionA` longtext NOT NULL,
  `optionB` longtext NOT NULL,
  `optionC` longtext NOT NULL,
  `optionD` longtext NOT NULL,
  `answer` longtext NOT NULL,
  `score` int(11) NOT NULL,
  `questionAddedBy` int(11) DEFAULT NULL,
  `questionAddedOn` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_bank`
--

INSERT INTO `question_bank` (`question_id`, `subject_topic_id`, `question_abbr`, `question`, `optionA`, `optionB`, `optionC`, `optionD`, `answer`, `score`, `questionAddedBy`, `questionAddedOn`) VALUES
(2, 1, 'LAQ', 'What are the three main purposes of an operating system?', '', '', '', '', 'To provide an environment for a computer user to execute programs\r\non computer hardware in a convenient and efficient manner.\r\nTo allocate the separate resources of the computer as needed to\r\nsolve the problem given. The allocation process should be as fair\r\nand efficient as possible.\r\nAs a control program it serves two major functions: (1) supervision\r\nof the execution of user programs to prevent errors and improper use\r\nof the computer, and (2) management of the operation and control\r\nof I/O devices.', 6, 1, '2022-06-02 10:07:38'),
(3, 1, 'SAQ', 'We have stressed the need for an operating system to make efficient use\r\nof the computing hardware. When is it appropriate for the operating\r\nsystem to forsake this principle and to “waste” resources? Why is such\r\na system not really wasteful?', '', '', '', '', 'Single-user systems should maximize use of the system for the user. A\r\nGUI might “waste” CPU cycles, but it optimizes the user’s interaction\r\nwith the system.', 2, 1, '2022-06-02 10:08:21'),
(5, 1, 'LAQ', 'Keeping in mind the various definitions of operating system, consider\r\nwhether the operating system should include applications such as Web\r\nbrowsers and mail programs. Argue both that it should and that it should\r\nnot, and support your answers.', '', '', '', '', 'An argument in favor of including popular applications with the\r\noperating system is that if the application is embedded within the\r\noperating system, it is likely to be better able to take advantage of\r\nfeatures in the kernel and therefore have performance advantages\r\nover an application that runs outside of the kernel. Arguments against\r\nembedding applications within the operating system typically dominate\r\nhowever: (1) the applications are applications - and not part of an\r\noperating system, (2) any performance benefits of running within the\r\nkernel are offset by security vulnerabilities, (3) it leads to a bloated\r\noperating system.', 8, 1, '2022-06-02 10:22:07'),
(6, 1, 'SAQ', 'How does the distinction between kernel mode and user mode function\r\nas a rudimentary form of protection (security) system?', '', '', '', '', 'The distinction between kernel mode and user mode provides a rudimentary form of protection in the following manner. Certain instructions\r\ncould be executed only when the CPU is in kernel mode. Similarly, hardware devices could be accessed only when the program is executing in\r\nkernel mode. Control over when interrupts could be enabled or disabled\r\nis also possible only when the CPU is in kernel mode. Consequently, the\r\nCPU has very limited capability when executing in user mode, thereby\r\nenforcing protection of critical resources.', 5, 1, '2022-06-02 10:22:52'),
(7, 1, 'SAQ', '\r\n            Which of the following instructions should be privileged?\r\na. Set value of timer.\r\nb. Read the clock.\r\nc. Clear memory.\r\nd. Issue a trap instruction.\r\ne. Turn off interrupts.\r\nf. Modify entries in device-status table.\r\ng. Switch from user to kernel mode.\r\nh. Access I/O device.            ', '', '', '', '', '\r\n            The following operations need to be privileged: Set value of timer, clear\r\nmemory, turn off interrupts, modify entries in device-status table, access\r\nI/O device. The rest can be performed in user mode.            ', 5, 1, '2022-06-02 10:23:23'),
(8, 1, 'SAQ', 'Some early computers protected the operating system by placing it in\r\na memory partition that could not be modified by either the user job\r\nor the operating system itself. Describe two difficulties that you think\r\ncould arise with such a scheme.', '', '', '', '', 'The data required by the operating system (passwords, access controls,\r\naccounting information, and so on) would have to be stored in or passed\r\nthrough unprotected memory and thus be accessible to unauthorized\r\nusers.', 2, 1, '2022-06-02 10:23:49'),
(9, 1, 'LAQ', 'Some CPUs provide for more than two modes of operation. What are\r\ntwo possible uses of these multiple modes?', '', '', '', '', 'Although most systems only distinguish between user and kernel\r\nmodes, some CPUs have supported multiple modes. Multiple modes\r\ncould be used to provide a finer-grained security policy. For example,\r\nrather than distinguishing between just user and kernel mode, you\r\ncould distinguish between different types of user mode. Perhaps users\r\nbelonging to the same group could execute each other’s code. The\r\nmachine would go into a specified mode when one of these users was\r\nrunning code. When the machine was in this mode, a member of the\r\ngroup could run code belonging to anyone else in the group.\r\nAnother possibility would be to provide different distinctions within\r\nkernel code. For example, a specific mode could allow USB device drivers\r\nto run. This would mean that USB devices could be serviced without\r\nhaving to switch to kernel mode, thereby essentially allowing USB device\r\ndrivers to run in a quasi-user/kernel mode.', 10, 1, '2022-06-02 10:24:23'),
(10, 1, 'SAQ', 'Timers could be used to compute the current time. Provide a short\r\ndescription of how this could be accomplished.', '', '', '', '', 'A program could use the following approach to compute the current\r\ntime using timer interrupts. The program could set a timer for some\r\ntime in the future and go to sleep. When it is awakened by the interrupt,\r\nit could update its local state, which it is using to keep track of the\r\nnumber of interrupts it has received thus far. It could then repeat this\r\nprocess of continually setting timer interrupts and updating its local\r\nstate when the interrupts are actually raised.', 4, 1, '2022-06-02 10:25:04'),
(11, 1, 'LAQ', 'Give two reasons why caches are useful. What problems do they solve?\r\nWhat problems do they cause? If a cache can be made as large as the\r\ndevice for which it is caching (for instance, a cache as large as a disk),\r\nwhy not make it that large and eliminate the device?', '', '', '', '', 'Caches are useful when two or more components need to exchange\r\ndata, and the components perform transfers at differing speeds. Caches\r\nsolve the transfer problem by providing a buffer of intermediate speed\r\nbetween the components. If the fast device finds the data it needs in the\r\ncache, it need not wait for the slower device. The data in the cache must\r\nbe kept consistent with the data in the components. If a component has\r\na data value change, and the datum is also in the cache, the cache must\r\nalso be updated. This is especially a problem on multiprocessor systems\r\nwhere more than one process may be accessing a datum. A component\r\nmay be eliminated by an equal-sized cache, but only if: (a) the cache\r\nand the component have equivalent state-saving capacity (that is, if the\r\ncomponent retains its data when electricity is removed, the cache must retain data as well), and (b) the cache is affordable, because faster storage\r\ntends to be more expensive.', 7, 1, '2022-06-02 10:25:58'),
(12, 1, 'LAQ', '\r\n            Distinguish between the client–server and peer-to-peer models of\r\ndistributed systems.            ', '', '', '', '', '<br><br><div id=\"div-11656160316\"><img src=\"./assets/images/exam/11656160316.jpg\" class=\"w-img\" id=\"11656160316\" ondblclick=\"resize(11656160316)\"></div>', 9, 1, '2022-06-02 10:26:22'),
(20, 1, 'SAQ', 'What is the main difficulty that a programmer must overcome in writing\r\nan operating system for a real-time environment?\r\n                        ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', 'The main difficulty is keeping the operating system within the fixed time\r\nconstraints of a real-time system. If the system does not complete a task\r\nin a certain time frame, it may cause a breakdown of the entire system it\r\nis running. Therefore when writing an operating system for a real-time\r\nsystem, the writer must be sure that his scheduling schemes don’t allow\r\nresponse time to exceed the time constraint.\r\n                                ', 4, 1, '2022-06-25 19:16:54'),
(23, 1, 'LAQ', 'In a multiprogramming and time-sharing environment, several users\r\nshare the system simultaneously. This situation can result in various\r\nsecurity problems. <br>\r\na. What are two such problems? <br>\r\nb. Can we ensure the same degree of security in a time-shared\r\nmachine as in a dedicated machine? Explain your answer.', '', '', '', '', 'a) Privacy Problem, Denial of Service, Integrity of Information <br>\r\n\r\nb) It cannot be ensured that the multiprogramming and time-sharing systems provides same degree of security as in a dedicated system. Because, in multiprogramming there may be a chance to steal or copying the files, code and programs can be overwritten and using the common resources without proper permission etc.\r\nA dedicated system can provide more security for the data and prevents stealing or overwriting the data of a process because, the system is dedicated to one\'s or belongs to specific purposes only.', 6, 1, '2022-06-25 19:48:56'),
(25, 1, 'LAQ', 'The issue of resource utilization shows up in different forms in different\r\ntypes of operating systems. List what resources must be managed\r\ncarefully in the following settings:<br> a. Mainframe or minicomputer systems <br>b. Workstations connected to servers <br>c. Mobile computers\r\n                        ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', 'Resource Management <br> Resource utilization is a major issue that occurs in different forms in different types of operating systems. It is important to manage resources to perform tasks efficiently and in a fair manner.<br> a) The resources that must be managed in Mainframe or Minicomputer Systems are listed below: <br>1. Memory Resources: Main memory (RAM) is an important part of the mainframe systems that must be carefully managed, as it is shared amongst a large number of users. <br>2. CPU Resources: Again, due to being shared amongst a lot of users it is important to manage CPU resources in mainframes and minicomputer systems. <br>3. Storage: Storage is an important resource that requires to be managed due to being shared amongst multiple users. <br>4. Network Bandwidth: Sharing of data is a major activity in systems shared by multiple users. It is important to manage network bandwidth in such systems. <br><br>b) The resources that must be managed in Workstations Connected to Servers are mentioned below: <br>1. Memory Resources: When workstations are connected to servers, multiple applications run on multiple workstations on a single server. This is an important factor due to which memory management is required in workstations connected to servers. <br>2. CPU Resources: Multiple workstations make requests to access resources to accomplish the tasks assigned to them. To ensure the fair and efficient completion of tasks, it is important to manage CPU resources in workstations connected to servers.<br><br>c) The resources that need to be managed in Handheld Computers are listed below: <br>1. Power Consumption: Handheld computers use compact, portable and small batteries as a source of power. It is important to manage power consumption in such devices to be able to make their use efficient and easy. <br>2. Memory Resources: Due to being small in size, the memory devices used in such computers are also small, thus deteriorating its storage capacity. This makes memory resource management an important requirement in handheld devices.', 15, 1, '2022-06-26 08:48:02'),
(26, 1, 'SAQ', '\r\n            Under what circumstances would a user be better off using a timesharing system than a PC or a single-user workstation?\r\n                                    ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', '\r\n            Time sharing system or multitasking is a logical extension of multiprogramming. In time-sharing, CPU executes multiple jobs by switching one after another process to execute. When switches occur frequently, then the user can interact with each program while it is running. But, multitasking and multiprogramming is not possible on single user work station. <br><br> The time sharing is best under following circumstances: <br>• In a work station, if there are few users to complete the large task, and hardware is fast, then at the point of time timesharing system is useful to complete the task with in the stipulated time.<br> • The other way to use the time sharing is when lots of users need so many resources at the\r\nsame time. <br><br><div>The Personal Computer is best under following circumstances:<br> • Personal computer is best, when the job is small enough to be executed with in short amount of time. <br> </div><div>The time-sharing system is better than PC under following circumstances: <br>• A time-sharing operating system uses CPU scheduling and multiprogramming to provide each user with a small portion of a time-shared computer.<br> • If other users need to access the same system, then a time-sharing system would work better than a PC or a single-user workstation.<br> • If there is only a single and exclusive user, then a PC or single-user workstation would be better to use the less amount of resources.<br> • To work remotely on the system, then time sharing system is useful then PC.\r\nTime sharing system is better than PC when compared to cost, and ease of use.            </div>', 5, 1, '2022-06-26 08:54:20'),
(27, 1, 'SAQ', 'How do clustered systems differ from multiprocessor systems? What is\r\nrequired for two machines belonging to a cluster to cooperate to provide\r\na highly available service? \r\n                        ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', 'It is made up of together of multiple CPUs to accomplish computational work. Clustered systems differ from multiprocessor systems, however, in that they are composed of two or more individual systems compiled together. It shares storage and are closely linked via LAN networking. <div>It provides high-availability service. i.e. service will continue to be provided even if one or more systems in the cluster fails. High-availability is generally obtained by adding a level of redundancy in the system. A layer of cluster software runs on the cluster nodes. Each node can monitor one or more of the others (over LAN). If the monitored machine fails, the monitoring machine can take ownership of its storage and restart the application that were running on failed machine.\r\n                                </div>', 4, 1, '2022-06-26 09:00:40'),
(28, 1, 'LAQ', 'Consider a computing cluster consisting of two nodes running a\r\ndatabase. Describe two ways in which the cluster software can manage\r\naccess to the data on the disk. Discuss the benefits and disadvantages of\r\neach.\r\n                        ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', 'Cluster Systems gather together multiple CPUs to accomplish computational work.<div><br></div><div>Cluster system differs from parallel system. The cluster computer share storage and are closely linked via LAN networking.</div><div><br></div><div>Clustering provides high-availability service will continue to be provided even if one or more system in the cluster fail. Clustering can be structured symmetrically or asymmetrically. In asymmetric clustering, one machine is in hot-standby mode, while the other is running the applications. The host - standby host machine does nothing but monitor the active server. If that server fails, the hot - standby host becomes the active server. </div><div><br></div><div>In symmetric mode, two or more hosts are running applications, and they are monitoring each other. This mode is more efficient, as it uses all the available hardware. It requires more than one application be available to run.\r\n                                </div>', 6, 1, '2022-06-26 09:02:28'),
(29, 1, 'LAQ', 'How are network computers different from traditional personal computers? Describe some usage scenarios in which it is advantageous to\r\nuse network computers.\r\n                        ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', 'Network computers versus personal computers\r\nPersonal computers (PC): <div><br></div><div>PCs are general purpose computers; those that are independent and can be used by a single user. Sharing of resources, communication is not possible in PCs. They have all the necessary resources local to the machine and are efficient in processing all the requests locally. </div><div><br></div><div>Network Computers: Network computers are the computers that are connected to each other through a network. It is possible to share resources and communicate with other computers in the network. They have very less resources locally and minimal operating system too. They rely on the server for all their required resources.\r\n                                </div><div><br></div><div>Types of networks: </div><div><br></div><div>LANS and WANs are the two basic type of network. LANs enable computers distributed over a small geographical area to communicate and share their resources. Where as WAN allow computers distributed over a large geographical area to communicate. </div><div><br></div><div>Real time examples and advantages of using network computers: </div><div>• E-mail a type of communication. Passing messages from one system to another system is possible using network computers. </div><div>• Web based computing helps to share information and files to all the systems that are connected to the network. </div><div>• Using messenger applications, real time communication (voice/text) is possible between the computers that are connected through network. </div><div>• Hardware resources can be shared between the systems that are connected through network. </div><div>• Troubleshooting the problems of a system can be done using another system on network from a remote location.<br></div>', 7, 1, '2022-06-26 10:04:50'),
(30, 1, 'SAQ', 'What is the purpose of interrupts? How does an interrupt differ from a\r\ntrap? Can traps be generated intentionally by a user program? If so, for\r\nwhat purpose?\r\n                        ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', 'Purpose of Interrupts:<div><br><div>Interrupts are generated by the hardware devices. In the case of happening of interrupts, there is no role of software. Interrupts are asynchronous or passive means if there is any instruction running then interrupt has to wait to happen. </div><div><br></div><div><br></div></div><table class=\"editable-table\"><caption>Interrupt VS Trap</caption><thead><tr><th>Interrupt</th><th>Trap</th></tr></thead><tbody><tr><td>It is a hardware signal</td><td>It is a software interrupt</td></tr><tr><td>It is caused by external events like graphics card, I/O port etc. </td><td>It is caused by software programs like divided by zero</td></tr><tr><td>It will not repeat as it is caused by an external event. </td><td>It can be repeat as it is software program. It can be repeated according to the calling of that instruction. </td></tr><tr><td>They can be handled by jump statements. </td><td>They cannot be handled by jump statements. </td></tr><tr><td>Interrupts are asynchronous events as they are related to external events. </td><td>Traps are caused by current program instructions; thus they are called as synchronous events. </td></tr></tbody></table><br><div>Yes, traps can be generated by the user program intentionally. </div><div><br></div><div>Purpose of calling Traps: </div><div><br></div><div>Traps can be used to call intentionally to call operating system routines or to catch arithmetic errors like divide by zero. </div>', 4, 1, '2022-06-26 11:01:25'),
(31, 1, 'MCQ', 'The systems which allow only one process execution at a time, are called __________\r\n                        ', 'Uni-programming systems\r\n                                                ', 'Uni-processing systems', 'Uni-tasking systems', 'none of the above', 'Uni-processing systems', 1, 1, '2022-06-26 11:24:30'),
(32, 1, 'SAQ', 'hi<div id=\"div-1111656501960\"><img src=\"./assets/images/exam/1111656501960.jpg\" class=\"w-img\" id=\"1111656501960\" ondblclick=\"resize(1111656501960)\"></div>', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', '\r\n                                                ', 'hi<table class=\"editable-table\"><caption>Difference Table</caption><thead><tr><th>cluster model</th><th>peer model</th></tr></thead><tbody><tr><td>Content 1</td><td>Content 2</td></tr><tr><td>Content 3</td><td>Content 4</td></tr><tr><td>Content 5</td><td>Content</td></tr><tr><td>Content</td><td>Content</td></tr></tbody></table>', 5, 2, '2022-06-29 18:27:26');

-- --------------------------------------------------------

--
-- Table structure for table `question_type`
--

CREATE TABLE `question_type` (
  `question_type_id` int(11) NOT NULL,
  `question_type_value` varchar(70) DEFAULT NULL,
  `question_abbr` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_type`
--

INSERT INTO `question_type` (`question_type_id`, `question_type_value`, `question_abbr`) VALUES
(1, 'Multiple Choice Question (MCQ)', 'MCQ'),
(2, 'Short Answer Question', 'SAQ'),
(3, 'Long Answer Question', 'LAQ');

-- --------------------------------------------------------

--
-- Table structure for table `subject_details`
--

CREATE TABLE `subject_details` (
  `subject_id` int(11) NOT NULL,
  `subject_code` varchar(30) NOT NULL,
  `subject_name` text NOT NULL,
  `major_id` int(11) DEFAULT NULL,
  `subjectAddedBy` int(11) DEFAULT NULL,
  `subjectAddedOn` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject_details`
--

INSERT INTO `subject_details` (`subject_id`, `subject_code`, `subject_name`, `major_id`, `subjectAddedBy`, `subjectAddedOn`) VALUES
(1, 'EGCI 351', 'Operating Systems', 1, 1, '2022-06-02 09:58:09'),
(2, 'EGCI 372', 'Data Communication and Computer Networks', 1, 1, '2022-06-15 17:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `subject_topic`
--

CREATE TABLE `subject_topic` (
  `subject_topic_id` int(11) NOT NULL,
  `subject_topic_name` text NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `topicAddedBy` int(11) DEFAULT NULL,
  `topicAddedOn` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject_topic`
--

INSERT INTO `subject_topic` (`subject_topic_id`, `subject_topic_name`, `subject_id`, `topicAddedBy`, `topicAddedOn`) VALUES
(1, 'Introduction', 1, 1, '2022-06-02 10:01:59'),
(2, 'Operating-System Structures', 1, 1, '2022-06-02 10:02:42'),
(3, 'Processes', 1, 1, '2022-06-02 10:02:50'),
(4, 'Threads', 1, 1, '2022-06-02 10:02:56'),
(5, 'Process Synchronization', 1, 1, '2022-06-02 10:03:04'),
(6, 'CPU Scheduling', 1, 1, '2022-06-02 10:03:10'),
(7, 'Deadlocks', 1, 1, '2022-06-02 10:03:19'),
(8, 'Main Memory', 1, 1, '2022-06-02 10:03:26'),
(9, 'Virtual Memory', 1, 1, '2022-06-02 10:03:33'),
(10, 'Mass-Storage Structure', 1, 1, '2022-06-02 10:03:39'),
(11, 'File-System Interface', 1, 1, '2022-06-02 10:03:46'),
(12, 'File-System Implementation', 1, 1, '2022-06-02 10:03:55'),
(13, 'I/O Systems', 1, 1, '2022-06-02 10:04:01'),
(14, 'Protection', 1, 1, '2022-06-02 10:04:07'),
(15, 'Security', 1, 1, '2022-06-02 10:04:14'),
(16, 'Virtual Machines', 1, 1, '2022-06-02 10:04:21'),
(17, 'Distributed Systems', 1, 1, '2022-06-02 10:04:27'),
(18, 'The Linux System', 1, 1, '2022-06-02 10:04:36'),
(19, 'Windows 7', 1, 1, '2022-06-02 10:04:42'),
(20, 'Influential Operating Systems', 1, 1, '2022-06-02 10:04:48'),
(21, 'BSD UNIX', 1, 1, '2022-06-02 10:05:00'),
(22, 'The Mach System', 1, 1, '2022-06-02 10:05:06'),
(23, 'Introduction', 2, 1, '2022-06-20 09:24:51');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_profile`
--

CREATE TABLE `teacher_profile` (
  `teacher_id` int(11) NOT NULL,
  `teacher_firstname` varchar(30) NOT NULL,
  `teacher_lastname` varchar(30) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `type` enum('Admin','Teacher') NOT NULL DEFAULT 'Teacher',
  `addedOn` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher_profile`
--

INSERT INTO `teacher_profile` (`teacher_id`, `teacher_firstname`, `teacher_lastname`, `email`, `password`, `type`, `addedOn`) VALUES
(1, 'Anshuman', 'Verma', 'dkanshuman@gmail.com', '$2y$10$JRlEMlD1S4RgCcH0PT0L0..NfdRW52FYijSO/RO2btTixkR1UTHm.', 'Admin', '2022-06-01 09:09:56'),
(2, 'Krish', 'Kukreja', 'krish.kuk@student.mahidol.edu', '$2y$10$JRlEMlD1S4RgCcH0PT0L0..NfdRW52FYijSO/RO2btTixkR1UTHm.', 'Teacher', '2022-06-02 09:51:29');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_subject_relation`
--

CREATE TABLE `teacher_subject_relation` (
  `teacherId` int(11) NOT NULL,
  `subjectId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher_subject_relation`
--

INSERT INTO `teacher_subject_relation` (`teacherId`, `subjectId`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `type_of_study`
--

CREATE TABLE `type_of_study` (
  `type_of_study_id` int(11) NOT NULL,
  `study_name` text DEFAULT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `studyAddedBy` int(11) DEFAULT NULL,
  `studyAddedOn` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type_of_study`
--

INSERT INTO `type_of_study` (`type_of_study_id`, `study_name`, `institute_id`, `studyAddedBy`, `studyAddedOn`) VALUES
(1, 'Undergraduate Degree', 4, 1, '2022-06-02 09:56:05'),
(2, 'Post-Graduate Degree', 4, 1, '2022-06-02 09:56:23'),
(3, 'PhD Degree', 4, 1, '2022-06-02 09:56:34'),
(4, 'Year 13', 3, 1, '2022-06-02 13:14:45'),
(5, 'Year 12', 3, 1, '2022-06-29 18:10:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`examId`),
  ADD KEY `instituteId` (`instituteId`),
  ADD KEY `studyId` (`studyId`),
  ADD KEY `majorId` (`majorId`),
  ADD KEY `subjectId` (`subjectId`),
  ADD KEY `examAddedBy` (`examAddedBy`);

--
-- Indexes for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD PRIMARY KEY (`examId`,`questionId`),
  ADD KEY `questionId` (`questionId`);

--
-- Indexes for table `exam_topics`
--
ALTER TABLE `exam_topics`
  ADD PRIMARY KEY (`examId`,`topicId`),
  ADD KEY `topicId` (`topicId`);

--
-- Indexes for table `exam_type`
--
ALTER TABLE `exam_type`
  ADD PRIMARY KEY (`examId`,`question_abbr`),
  ADD KEY `question_abbr` (`question_abbr`);

--
-- Indexes for table `institute`
--
ALTER TABLE `institute`
  ADD PRIMARY KEY (`institute_id`),
  ADD UNIQUE KEY `institute_name` (`institute_name`),
  ADD KEY `instituteAddedBy` (`instituteAddedBy`);

--
-- Indexes for table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`major_id`),
  ADD KEY `majorAddedBy` (`majorAddedBy`),
  ADD KEY `type_of_study_id` (`type_of_study_id`);

--
-- Indexes for table `question_bank`
--
ALTER TABLE `question_bank`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `questionAddedBy` (`questionAddedBy`),
  ADD KEY `subject_topic_id` (`subject_topic_id`),
  ADD KEY `question_abbr` (`question_abbr`);

--
-- Indexes for table `question_type`
--
ALTER TABLE `question_type`
  ADD PRIMARY KEY (`question_type_id`),
  ADD UNIQUE KEY `question_type_value` (`question_type_value`),
  ADD UNIQUE KEY `question_abbr` (`question_abbr`);

--
-- Indexes for table `subject_details`
--
ALTER TABLE `subject_details`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `subjectAddedBy` (`subjectAddedBy`),
  ADD KEY `major_id` (`major_id`);

--
-- Indexes for table `subject_topic`
--
ALTER TABLE `subject_topic`
  ADD PRIMARY KEY (`subject_topic_id`),
  ADD KEY `topicAddedBy` (`topicAddedBy`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `teacher_subject_relation`
--
ALTER TABLE `teacher_subject_relation`
  ADD PRIMARY KEY (`teacherId`,`subjectId`),
  ADD KEY `subjectId` (`subjectId`);

--
-- Indexes for table `type_of_study`
--
ALTER TABLE `type_of_study`
  ADD PRIMARY KEY (`type_of_study_id`),
  ADD KEY `studyAddedBy` (`studyAddedBy`),
  ADD KEY `institute_id` (`institute_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `examId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `institute`
--
ALTER TABLE `institute`
  MODIFY `institute_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `major`
--
ALTER TABLE `major`
  MODIFY `major_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `question_bank`
--
ALTER TABLE `question_bank`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `question_type`
--
ALTER TABLE `question_type`
  MODIFY `question_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subject_details`
--
ALTER TABLE `subject_details`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subject_topic`
--
ALTER TABLE `subject_topic`
  MODIFY `subject_topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `type_of_study`
--
ALTER TABLE `type_of_study`
  MODIFY `type_of_study_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`instituteId`) REFERENCES `institute` (`institute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_ibfk_2` FOREIGN KEY (`studyId`) REFERENCES `type_of_study` (`type_of_study_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_ibfk_3` FOREIGN KEY (`majorId`) REFERENCES `major` (`major_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_ibfk_4` FOREIGN KEY (`subjectId`) REFERENCES `subject_details` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_ibfk_5` FOREIGN KEY (`examAddedBy`) REFERENCES `teacher_profile` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD CONSTRAINT `exam_questions_ibfk_1` FOREIGN KEY (`examId`) REFERENCES `exam` (`examId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_questions_ibfk_2` FOREIGN KEY (`questionId`) REFERENCES `question_bank` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_topics`
--
ALTER TABLE `exam_topics`
  ADD CONSTRAINT `exam_topics_ibfk_1` FOREIGN KEY (`examId`) REFERENCES `exam` (`examId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_topics_ibfk_2` FOREIGN KEY (`topicId`) REFERENCES `subject_topic` (`subject_topic_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_type`
--
ALTER TABLE `exam_type`
  ADD CONSTRAINT `exam_type_ibfk_1` FOREIGN KEY (`examId`) REFERENCES `exam` (`examId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_type_ibfk_2` FOREIGN KEY (`question_abbr`) REFERENCES `question_type` (`question_abbr`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `institute`
--
ALTER TABLE `institute`
  ADD CONSTRAINT `institute_ibfk_1` FOREIGN KEY (`instituteAddedBy`) REFERENCES `teacher_profile` (`teacher_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `major`
--
ALTER TABLE `major`
  ADD CONSTRAINT `major_ibfk_1` FOREIGN KEY (`majorAddedBy`) REFERENCES `teacher_profile` (`teacher_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `major_ibfk_2` FOREIGN KEY (`type_of_study_id`) REFERENCES `type_of_study` (`type_of_study_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `question_bank`
--
ALTER TABLE `question_bank`
  ADD CONSTRAINT `question_bank_ibfk_1` FOREIGN KEY (`questionAddedBy`) REFERENCES `teacher_profile` (`teacher_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `question_bank_ibfk_2` FOREIGN KEY (`subject_topic_id`) REFERENCES `subject_topic` (`subject_topic_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `question_bank_ibfk_3` FOREIGN KEY (`question_abbr`) REFERENCES `question_type` (`question_abbr`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `subject_details`
--
ALTER TABLE `subject_details`
  ADD CONSTRAINT `subject_details_ibfk_1` FOREIGN KEY (`subjectAddedBy`) REFERENCES `teacher_profile` (`teacher_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `subject_details_ibfk_2` FOREIGN KEY (`major_id`) REFERENCES `major` (`major_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `subject_topic`
--
ALTER TABLE `subject_topic`
  ADD CONSTRAINT `subject_topic_ibfk_1` FOREIGN KEY (`topicAddedBy`) REFERENCES `teacher_profile` (`teacher_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `subject_topic_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject_details` (`subject_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `teacher_subject_relation`
--
ALTER TABLE `teacher_subject_relation`
  ADD CONSTRAINT `teacher_subject_relation_ibfk_1` FOREIGN KEY (`teacherId`) REFERENCES `teacher_profile` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_subject_relation_ibfk_2` FOREIGN KEY (`subjectId`) REFERENCES `subject_details` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `type_of_study`
--
ALTER TABLE `type_of_study`
  ADD CONSTRAINT `type_of_study_ibfk_1` FOREIGN KEY (`studyAddedBy`) REFERENCES `teacher_profile` (`teacher_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `type_of_study_ibfk_2` FOREIGN KEY (`institute_id`) REFERENCES `institute` (`institute_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `teacher_profile` (
  `teacher_id` int PRIMARY KEY AUTO_INCREMENT,
  `teacher_firstname` varchar(30) NOT NULL,
  `teacher_lastname` varchar(30) NOT NULL,
  `email` varchar(50) UNIQUE,
  `password` varchar(100) NOT NULL,
  `type` ENUM('Admin','Teacher') NOT NULL DEFAULT 'Teacher',
  `addedOn` DATETIME DEFAULT CURRENT_TIMESTAMP
); 


CREATE TABLE `institute`(
    `institute_id` int PRIMARY KEY AUTO_INCREMENT,
    `institute_name` varchar(100) UNIQUE,
    `instituteAddedBy` int,
    `instituteAddedOn` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`instituteAddedBy`) REFERENCES `teacher_profile`(`teacher_id`) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE `type_of_study`(
    `type_of_study_id` int PRIMARY KEY AUTO_INCREMENT,
    `study_name` text,
    `institute_id` int,
    `studyAddedBy` int,
   `studyAddedOn` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`studyAddedBy`) REFERENCES `teacher_profile`(`teacher_id`) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (`institute_id`) REFERENCES `institute`(`institute_id`) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE `major`(
    `major_id` int PRIMARY KEY AUTO_INCREMENT,
    `major_name` text,
    `type_of_study_id` int,
    `majorAddedBy` int,
   `majorAddedOn` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`majorAddedBy`) REFERENCES `teacher_profile`(`teacher_id`) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (`type_of_study_id`) REFERENCES `type_of_study`(`type_of_study_id`) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE `subject_details` (
  `subject_id` int PRIMARY KEY AUTO_INCREMENT,
  `subject_code` varchar(30) NOT NULL,
  `subject_name` TEXT NOT NULL,
  `major_id` int,
  `subjectAddedBy` int,
  `subjectAddedOn` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`subjectAddedBy`) REFERENCES `teacher_profile`(`teacher_id`) ON UPDATE CASCADE ON DELETE SET NULL,
  FOREIGN KEY (`major_id`) REFERENCES `major`(`major_id`) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE `teacher_subject_relation` (
  `teacherId` int,
  `subjectId` int,
  PRIMARY KEY (`teacherId`, `subjectId`),
  FOREIGN KEY (`teacherId`) REFERENCES `teacher_profile`(`teacher_id`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`subjectId`) REFERENCES `subject_details`(`subject_id`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `subject_topic` (
  `subject_topic_id` int PRIMARY KEY AUTO_INCREMENT,
  `subject_topic_name` text NOT NULL,
  `subject_id` int,
  `topicAddedBy` int,
   `topicAddedOn` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`topicAddedBy`) REFERENCES `teacher_profile`(`teacher_id`) ON UPDATE CASCADE ON DELETE SET NULL,
  FOREIGN KEY (`subject_id`) REFERENCES `subject_details`(`subject_id`) ON UPDATE CASCADE ON DELETE SET NULL
);


CREATE TABLE `question_type` (
  `question_type_id` int PRIMARY KEY AUTO_INCREMENT,
  `question_type_value` varchar(70) UNIQUE,
  `question_abbr` varchar(30) UNIQUE
);

CREATE TABLE `question_bank` (
  `question_id` int PRIMARY KEY AUTO_INCREMENT,
  `subject_topic_id` int,
  `question_abbr` varchar(30),
  `question` longtext NOT NULL,
  `optionA` longtext NOT NULL,
  `optionB` longtext NOT NULL,
  `optionC` longtext NOT NULL,
  `optionD` longtext NOT NULL,
  `answer` longtext NOT NULL,
  `score` int NOT NULL,
  `questionAddedBy` int,
   `questionAddedOn` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`questionAddedBy`) REFERENCES `teacher_profile`(`teacher_id`) ON UPDATE CASCADE ON DELETE SET NULL,
  FOREIGN KEY (`Subject_topic_id`) REFERENCES `subject_topic`(`subject_topic_id`) ON UPDATE CASCADE ON DELETE SET NULL,
  FOREIGN KEY (`question_abbr`) REFERENCES `question_type`(`question_abbr`) ON UPDATE CASCADE ON DELETE SET NULL
);


CREATE TABLE `exam` (
  `examId` int PRIMARY KEY AUTO_INCREMENT,
  `instituteId` int,
  `studyId` int,
  `majorId` int,
  `subjectId` int,
  `examMode` ENUM('Manual','Random'),
  `examName` VARCHAR(100),
  `semester` VARCHAR(12)
  `examAddedBy` int,
  `examAddedOn` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`instituteId`) REFERENCES `institute`(`institute_id`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`studyId`) REFERENCES `type_of_study`(`type_of_study_id`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`majorId`) REFERENCES `major`(`major_id`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`subjectId`) REFERENCES `subject_details`(`subject_id`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`examAddedBy`) REFERENCES `teacher_profile`(`teacher_id`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `exam_topics` (
  `examId` int,
  `topicId` int,
  `score` int,
  PRIMARY KEY (`examId`, `topicId`),
  FOREIGN KEY (`examId`) REFERENCES `exam`(`examId`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`topicId`) REFERENCES `subject_topic`(`subject_topic_id`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `exam_type` (
  `examId` int,
  `question_abbr` varchar(30),
  PRIMARY KEY(`examId`, `question_abbr`),
  FOREIGN KEY (`examId`) REFERENCES `exam`(`examId`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`question_abbr`) REFERENCES `question_type`(`question_abbr`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `exam_questions`(
  `examId` int,
  `questionId` int,
  `score` int,
  `questionOrder` int,
  PRIMARY KEY(`examId`, `questionId`),
  FOREIGN KEY (`examId`) REFERENCES `exam`(`examId`) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (`questionId`) REFERENCES `question_bank`(`question_id`) ON UPDATE CASCADE ON DELETE CASCADE
);


INSERT INTO `question_type` (`question_type_value`, `question_abbr`) VALUES
('Multiple Choice Question (MCQ)', 'MCQ'),
('Short Answer Question', 'SAQ'),
('Long Answer Question', 'LAQ');




INSERT INTO `teacher_profile` (`teacher_id`, `teacher_firstname`, `teacher_lastname`, `email`, `password`, `type`, `addedOn`) VALUES
(1, 'Anshuman', 'Verma', 'dkanshuman@gmail.com', '$2y$10$JRlEMlD1S4RgCcH0PT0L0..NfdRW52FYijSO/RO2btTixkR1UTHm.', 'Admin', '2022-06-01 09:09:56'),
(2, 'Krish', 'Kukreja', 'krish.kuk@student.mahidol.edu', '$2y$10$JRlEMlD1S4RgCcH0PT0L0..NfdRW52FYijSO/RO2btTixkR1UTHm.', 'Teacher', '2022-06-02 09:51:29');


INSERT INTO `institute` (`institute_id`, `institute_name`, `instituteAddedBy`, `instituteAddedOn`) VALUES
(1, 'Primary School', 1, '2022-06-02 09:54:59'),
(2, 'Middle School', 1, '2022-06-02 09:55:05'),
(3, 'High School', 1, '2022-06-02 09:55:11'),
(4, 'University', 1, '2022-06-02 09:55:24');


INSERT INTO `type_of_study` (`type_of_study_id`, `study_name`, `institute_id`, `studyAddedBy`, `studyAddedOn`) VALUES
(1, 'Undergraduate Degree', 4, 1, '2022-06-02 09:56:05'),
(2, 'Post-Graduate Degree', 4, 1, '2022-06-02 09:56:23'),
(3, 'PhD Degree', 4, 1, '2022-06-02 09:56:34'),
(4, 'Year 13', 3, 1, '2022-06-02 13:14:45');

INSERT INTO `major` (`major_id`, `major_name`, `type_of_study_id`, `majorAddedBy`, `majorAddedOn`) VALUES
(1, 'Computer Engineering', 1, 1, '2022-06-02 09:57:17'),
(2, 'Biological Sciences', 1, 1, '2022-06-02 09:57:37');

INSERT INTO `subject_details` (`subject_id`, `subject_code`, `subject_name`, `major_id`, `subjectAddedBy`, `subjectAddedOn`) VALUES
(1, 'EGCI 351', 'Operating Systems', 1, 1, '2022-06-02 09:58:09');

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
(22, 'The Mach System', 1, 1, '2022-06-02 10:05:06');


INSERT INTO `question_bank` (`subject_topic_id`, `question_abbr`, `question`, `optionA`, `optionB`, `optionC`, `optionD`, `answer`, `score`, `questionAddedBy`, `questionAddedOn`) VALUES
(1, 'LAQ', 'What are the three main purposes of an operating system?', '', '', '', '', 'To provide an environment for a computer user to execute programs\r\non computer hardware in a convenient and efficient manner.\r\nTo allocate the separate resources of the computer as needed to\r\nsolve the problem given. The allocation process should be as fair\r\nand efficient as possible.\r\nAs a control program it serves two major functions: (1) supervision\r\nof the execution of user programs to prevent errors and improper use\r\nof the computer, and (2) management of the operation and control\r\nof I/O devices.', 6, 1, '2022-06-02 10:07:38'),
(1, 'SAQ', 'We have stressed the need for an operating system to make efficient use\r\nof the computing hardware. When is it appropriate for the operating\r\nsystem to forsake this principle and to “waste” resources? Why is such\r\na system not really wasteful?', '', '', '', '', 'Single-user systems should maximize use of the system for the user. A\r\nGUI might “waste” CPU cycles, but it optimizes the user’s interaction\r\nwith the system.', 2, 1, '2022-06-02 10:08:21'),
(1, 'SAQ', 'What is the main difficulty that a programmer must overcome in writing\r\nan operating system for a real-time environment?', '', '', '', '', 'The main difficulty is keeping the operating system within the fixed time\r\nconstraints of a real-time system. If the system does not complete a task\r\nin a certain time frame, it may cause a breakdown of the entire system it\r\nis running. Therefore when writing an operating system for a real-time\r\nsystem, the writer must be sure that his scheduling schemes don’t allow\r\nresponse time to exceed the time constraint.', 3, 1, '2022-06-02 10:09:14'),
(1, 'LAQ', 'Keeping in mind the various definitions of operating system, consider\r\nwhether the operating system should include applications such as Web\r\nbrowsers and mail programs. Argue both that it should and that it should\r\nnot, and support your answers.', '', '', '', '', 'An argument in favor of including popular applications with the\r\noperating system is that if the application is embedded within the\r\noperating system, it is likely to be better able to take advantage of\r\nfeatures in the kernel and therefore have performance advantages\r\nover an application that runs outside of the kernel. Arguments against\r\nembedding applications within the operating system typically dominate\r\nhowever: (1) the applications are applications - and not part of an\r\noperating system, (2) any performance benefits of running within the\r\nkernel are offset by security vulnerabilities, (3) it leads to a bloated\r\noperating system.', 8, 1, '2022-06-02 10:22:07'),
(1, 'SAQ', 'How does the distinction between kernel mode and user mode function\r\nas a rudimentary form of protection (security) system?', '', '', '', '', 'The distinction between kernel mode and user mode provides a rudimentary form of protection in the following manner. Certain instructions\r\ncould be executed only when the CPU is in kernel mode. Similarly, hardware devices could be accessed only when the program is executing in\r\nkernel mode. Control over when interrupts could be enabled or disabled\r\nis also possible only when the CPU is in kernel mode. Consequently, the\r\nCPU has very limited capability when executing in user mode, thereby\r\nenforcing protection of critical resources.', 5, 1, '2022-06-02 10:22:52'),
(1, 'SAQ', 'Which of the following instructions should be privileged?\r\na. Set value of timer.\r\nb. Read the clock.\r\nc. Clear memory.\r\nd. Issue a trap instruction.\r\ne. Turn off interrupts.\r\nf. Modify entries in device-status table.\r\ng. Switch from user to kernel mode.\r\nh. Access I/O device.', '', '', '', '', 'The following operations need to be privileged: Set value of timer, clear\r\nmemory, turn off interrupts, modify entries in device-status table, access\r\nI/O device. The rest can be performed in user mode.', 5, 1, '2022-06-02 10:23:23'),
(1, 'SAQ', 'Some early computers protected the operating system by placing it in\r\na memory partition that could not be modified by either the user job\r\nor the operating system itself. Describe two difficulties that you think\r\ncould arise with such a scheme.', '', '', '', '', 'The data required by the operating system (passwords, access controls,\r\naccounting information, and so on) would have to be stored in or passed\r\nthrough unprotected memory and thus be accessible to unauthorized\r\nusers.', 2, 1, '2022-06-02 10:23:49'),
(1, 'LAQ', 'Some CPUs provide for more than two modes of operation. What are\r\ntwo possible uses of these multiple modes?', '', '', '', '', 'Although most systems only distinguish between user and kernel\r\nmodes, some CPUs have supported multiple modes. Multiple modes\r\ncould be used to provide a finer-grained security policy. For example,\r\nrather than distinguishing between just user and kernel mode, you\r\ncould distinguish between different types of user mode. Perhaps users\r\nbelonging to the same group could execute each other’s code. The\r\nmachine would go into a specified mode when one of these users was\r\nrunning code. When the machine was in this mode, a member of the\r\ngroup could run code belonging to anyone else in the group.\r\nAnother possibility would be to provide different distinctions within\r\nkernel code. For example, a specific mode could allow USB device drivers\r\nto run. This would mean that USB devices could be serviced without\r\nhaving to switch to kernel mode, thereby essentially allowing USB device\r\ndrivers to run in a quasi-user/kernel mode.', 10, 1, '2022-06-02 10:24:23'),
(1, 'SAQ', 'Timers could be used to compute the current time. Provide a short\r\ndescription of how this could be accomplished.', '', '', '', '', 'A program could use the following approach to compute the current\r\ntime using timer interrupts. The program could set a timer for some\r\ntime in the future and go to sleep. When it is awakened by the interrupt,\r\nit could update its local state, which it is using to keep track of the\r\nnumber of interrupts it has received thus far. It could then repeat this\r\nprocess of continually setting timer interrupts and updating its local\r\nstate when the interrupts are actually raised.', 4, 1, '2022-06-02 10:25:04'),
(1, 'LAQ', 'Give two reasons why caches are useful. What problems do they solve?\r\nWhat problems do they cause? If a cache can be made as large as the\r\ndevice for which it is caching (for instance, a cache as large as a disk),\r\nwhy not make it that large and eliminate the device?', '', '', '', '', 'Caches are useful when two or more components need to exchange\r\ndata, and the components perform transfers at differing speeds. Caches\r\nsolve the transfer problem by providing a buffer of intermediate speed\r\nbetween the components. If the fast device finds the data it needs in the\r\ncache, it need not wait for the slower device. The data in the cache must\r\nbe kept consistent with the data in the components. If a component has\r\na data value change, and the datum is also in the cache, the cache must\r\nalso be updated. This is especially a problem on multiprocessor systems\r\nwhere more than one process may be accessing a datum. A component\r\nmay be eliminated by an equal-sized cache, but only if: (a) the cache\r\nand the component have equivalent state-saving capacity (that is, if the\r\ncomponent retains its data when electricity is removed, the cache must retain data as well), and (b) the cache is affordable, because faster storage\r\ntends to be more expensive.', 7, 1, '2022-06-02 10:25:58'),
(1, 'LAQ', 'Distinguish between the client–server and peer-to-peer models of\r\ndistributed systems.', '', '', '', '', 'The client-server model firmly distinguishes the roles of the client and\r\nserver. Under this model, the client requests services that are provided\r\nby the server. The peer-to-peer model doesn’t have such strict roles. In\r\nfact, all nodes in the system are considered peers and thus may act as\r\neither clients or servers—or both. A node may request a service from\r\nanother peer, or the node may in fact provide such a service to other\r\npeers in the system.\r\nFor example, let’s consider a system of nodes that share cooking\r\nrecipes. Under the client-server model, all recipes are stored with the\r\nserver. If a client wishes to access a recipe, it must request the recipe from\r\nthe specified server. Using the peer-to-peer model, a peer node could ask\r\nother peer nodes for the specified recipe. The node (or perhaps nodes)\r\nwith the requested recipe could provide it to the requesting node. Notice\r\nhow each peer may act as both a client (it may request recipes) and as a\r\nserver (it may provide recipes).', 9, 1, '2022-06-02 10:26:22'),
(1, 'LAQ', 'In a multiprogramming and time-sharing environment, several users\r\nshare the system simultaneously. This situation can result in various\r\nsecurity problems.\r\na. What are two such problems?\r\nb. Can we ensure the same degree of security in a time-shared\r\nmachine as in a dedicated machine? Explain your answer.', '', '', '', '', '-----', 10, 2, '2022-06-02 13:23:22'),
(2, 'SAQ', 'What is the purpose of system calls?', '', '', '', '', '-----', 2, 1, '2022-06-02 13:28:04');


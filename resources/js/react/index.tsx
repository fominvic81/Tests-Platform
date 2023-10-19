export const examId = 'exam-exam';
export const testEditId = 'test-edit';
export const testCreateId = 'test-create';
export const courseEditId = 'course-edit';
export const courseCreateId = 'course-create';

if (document.getElementById(examId)) import('./pages/exam/exam');
if (document.getElementById(testEditId)) import('./pages/test/edit');
if (document.getElementById(testCreateId)) import('./pages/test/create');
if (document.getElementById(courseEditId)) import('./pages/course/edit');
if (document.getElementById(courseCreateId)) import('./pages/course/create');
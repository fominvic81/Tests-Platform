export const testEditorId = 'test-editor';
export const testExaminatorId = 'test-examinator';

if (document.getElementById(testEditorId)) import('./pages/testEditor');
if (document.getElementById(testExaminatorId)) import('./pages/testExaminator');
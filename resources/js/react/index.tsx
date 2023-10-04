export const testExaminatorComponentId = 'test-examinator';
export const testEditorId = 'test-editor';

if (document.getElementById(testExaminatorComponentId)) import('./pages/testExaminator');
if (document.getElementById(testEditorId)) import('./pages/testEditor');
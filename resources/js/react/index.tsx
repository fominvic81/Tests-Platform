export const testEditId = 'test-edit';
export const TestingShowId = 'testing-show';

if (document.getElementById(testEditId)) import('./pages/test/edit');
if (document.getElementById(TestingShowId)) import('./pages/testing/show');